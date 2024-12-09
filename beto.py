import pandas as pd
import torch
from torch import nn, optim
from transformers import BertModel, BertTokenizer, AdamW, get_linear_schedule_with_warmup, BertForSequenceClassification
from torch.utils.data import Dataset, DataLoader
import numpy as np
from sklearn.model_selection import train_test_split
import json  # Agrega esta importación
import os

class MyDataset(Dataset):
    def __init__(self, reviews, labels, tokenizer, max_len):
        self.reviews = reviews
        self.labels = labels
        self.tokenizer = tokenizer
        self.max_len = max_len

    def __len__(self):
        return len(self.reviews)

    def __getitem__(self, item):
        review = str(self.reviews[item])
        label = self.labels[item]
        # Map sentiment labels to 'negative', 'neutral', 'positive'

        if label == 1:
            label = 0  # Negative
        elif label == 2:
            label = 1  # Neutral
        elif label == 3:
            label = 2 
        elif label == 4:
            label = 3  # Neutral
        elif label == 5:
            label = 4  # Positive
        else:
            raise ValueError(f"Invalid label: {label}")
        encoding = self.tokenizer.encode_plus(
            review,
            max_length=self.max_len,
            truncation=True,
            add_special_tokens=True,
            return_token_type_ids=False,
            pad_to_max_length=True,
            return_attention_mask=True,
            return_tensors='pt'
        )

        return {
            'review': review,
            'input_ids': encoding['input_ids'].flatten(),
            'attention_mask': encoding['attention_mask'].flatten(),
            'label': torch.tensor(label, dtype=torch.long)
        }


# Agrega el siguiente bloque de código para evitar el warning mencionado anteriormente.

os.environ['WANDB_DISABLED'] = 'true'  # Esta línea evita el warning

if __name__ == "__main__":
    RANDOM_SEED = 42
    MAX_LEN = 200
    BATCH_SIZE = 16
    DATASET_PATH = 'Reporte2.csv'
    NCLASSES = 5

    np.random.seed(RANDOM_SEED)
    torch.manual_seed(RANDOM_SEED)
    device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")
    print(device)

    # Carga de datos
    df = pd.read_csv("Reporte2.csv")

    # Cargo el modelo BERT
    berto = "dccuchile/bert-base-spanish-wwm-cased"
    tokenizer = BertTokenizer.from_pretrained(berto)
    model = BertForSequenceClassification.from_pretrained(berto)

    # Ejemplo tokenización
    sample_txt = 'Porque cada miércoles que tengo descuento para cargar V power la app no funciona. Me ha pasado más de una vez. Por lo tanto es publicidad engañosa. Es una pena porque el combustible es de primera '
    tokens = tokenizer.tokenize(sample_txt)
    token_ids = tokenizer.convert_tokens_to_ids(tokens)
    print('Frase: ', sample_txt)
    print('Tokens: ', tokens)
    print('Tokens numéricos: ', token_ids)

    # Codificación para introducir a BERT
    encoding = tokenizer.encode_plus(
        sample_txt,
        max_length=120,
        truncation=True,
        add_special_tokens=True,
        return_token_type_ids=False,
        padding='max_length',
        return_attention_mask=True,
        return_tensors='pt'
    )

    encoding.keys()
    print(encoding.keys())
    print(tokenizer.convert_ids_to_tokens(encoding['input_ids'][0]))
    print(encoding['input_ids'][0])
    print(encoding['attention_mask'][0])


    # CREACIÓN DATASET


    # Creación del DataLoader
    def data_loader(df, tokenizer, max_len, batch_size):
        dataset = MyDataset(
            reviews=df.reviews.to_numpy(),
            labels=df.label.to_numpy(),
            tokenizer=tokenizer,
            max_len=MAX_LEN
        )

        return DataLoader(dataset, batch_size=BATCH_SIZE, num_workers=4)

    df_train, df_test = train_test_split(df, test_size=0.2, random_state=RANDOM_SEED)

    train_data_loader = data_loader(df_train, tokenizer, MAX_LEN, BATCH_SIZE)
    test_data_loader = data_loader(df_test, tokenizer, MAX_LEN, BATCH_SIZE)

    # Modelo
   

    class BERTSentimentClassifier(nn.Module):
        def __init__(self, n_classes):
            super(BERTSentimentClassifier, self).__init__()
            self.device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")
            
            self.bert = BertModel.from_pretrained(berto)
            self.drop = nn.Dropout(p=0.3)
            self.linear = nn.Linear(self.bert.config.hidden_size, n_classes)
            
            self.to(self.device)  # Mover el modelo a la GPU o la CPU, según la disponibilidad

        def forward(self, input_ids, attention_mask):
            outputs = self.bert(
                input_ids=input_ids,
                attention_mask=attention_mask
            )
            pooler_output = outputs.pooler_output
            drop_output = self.drop(pooler_output)
            output = self.linear(drop_output)
            return output

    
    model = BERTSentimentClassifier(NCLASSES)
    model = model.to(device)

    # Entrenamiento
    EPOCHS = 1
    optimizer = AdamW(model.parameters(), lr=2e-5, correct_bias=False)
    total_steps = len(train_data_loader) * EPOCHS
    scheduler = get_linear_schedule_with_warmup(
        optimizer,
        num_warmup_steps=0,
        num_training_steps=total_steps
    )
    loss_fn = nn.CrossEntropyLoss().to(device)

    # Funciones de entrenamiento y evaluación
    def train_model(model, data_loader, loss_fn, optimizer, device, scheduler, n_examples):
        model = model.train()
        losses = []
        correct_predictions = 0
        for batch in data_loader:
            input_ids = batch['input_ids'].to(device)
            attention_mask = batch['attention_mask'].to(device)
            labels = batch['label'].to(device)
            outputs = model(input_ids=input_ids, attention_mask=attention_mask)
            _, preds = torch.max(outputs, dim=1)
            loss = loss_fn(outputs, labels)
            correct_predictions += torch.sum(preds == labels)
            losses.append(loss.item())
            loss.backward()
            nn.utils.clip_grad_norm_(model.parameters(), max_norm=1.0)
            optimizer.step()
            scheduler.step()
            optimizer.zero_grad()
        return correct_predictions.double() / n_examples, np.mean(losses)

    def eval_model(model, data_loader, loss_fn, device, n_examples):
        model = model.eval()
        losses = []
        correct_predictions = 0
        with torch.no_grad():
            for batch in data_loader:
                input_ids = batch['input_ids'].to(device)
                attention_mask = batch['attention_mask'].to(device)
                labels = batch['label'].to(device)
                outputs = model(input_ids=input_ids, attention_mask=attention_mask)
                _, preds = torch.max(outputs, dim=1)
                loss = loss_fn(outputs, labels)
                correct_predictions += torch.sum(preds == labels)
                losses.append(loss.item())
        return correct_predictions.double() / n_examples, np.mean(losses)

    # Bucle de entrenamiento
    for epoch in range(EPOCHS):
        print('Epoch {} de {}'.format(epoch + 1, EPOCHS))
        print('------------------')
        train_acc, train_loss = train_model(
            model, train_data_loader, loss_fn, optimizer, device, scheduler, len(df_train)
        )
        test_acc, test_loss = eval_model(
            model, test_data_loader, loss_fn, device, len(df_test)
        )
        print('Entrenamiento: Loss: {}, accuracy: {}'.format(train_loss, train_acc))
        print('Validación: Loss: {}, accuracy: {}'.format(test_loss, test_acc))
        print('')

    # Función para clasificar la opinión
    def classifySentiment(review_text):
        encoding_review = tokenizer.encode_plus(
            review_text,
            max_length=MAX_LEN,
            truncation=True,
            add_special_tokens=True,
            return_token_type_ids=False,
            pad_to_max_length=True,
            return_attention_mask=True,
            return_tensors='pt'
        )

        input_ids = encoding_review['input_ids'].to(device)
        attention_mask = encoding_review['attention_mask'].to(device)
        output = model(input_ids, attention_mask)
        _, prediction = torch.max(output, dim=1)
        
        
        return prediction.item() + 1  # Sumar 1 para obtener la clasificación en lugar de la etiqueta

    # Ejemplo de clasificación
    # review_text = 'Muy buena la atencion'
    # clasificacion = classifySentiment(review_text)
    # print("Clasificación de la opinión:", clasificacion)

    # Guardar el modelo (opcional)
    torch.save(model.state_dict(), 'modelo_entrenado11.pth')
    print("Modelo guardado exitosamente.")
