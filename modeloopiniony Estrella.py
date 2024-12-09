import torch
from transformers import BertTokenizer, BertForSequenceClassification, BertForSequenceRegression
from sklearn.model_selection import train_test_split
from torch.utils.data import DataLoader, TensorDataset
from tqdm import tqdm

# Leer los datos
# Asumiendo que tienes un archivo CSV con tres columnas: "opinion", "calificacion", "categoria"
data = pd.read_csv("datos_multitarea.csv")

# Dividir los datos en conjuntos de entrenamiento y prueba
train_data, test_data = train_test_split(data, test_size=0.2, random_state=42)

# Cargar el modelo preentrenado y el tokenizador para clasificación y regresión
classification_model = BertForSequenceClassification.from_pretrained('bert-base-uncased', num_labels=2)
regression_model = BertForSequenceRegression.from_pretrained('bert-base-uncased')

tokenizer = BertTokenizer.from_pretrained('bert-base-uncased')

# Tokenizar y formatear los datos
def tokenize_data_multitask(texts, labels, tokenizer, max_len=128):
    input_ids = []
    attention_masks = []
    labels_classification = []
    labels_regression = []

    for text, label_classification, label_regression in tqdm(zip(texts, labels["calificacion"], labels["categoria"]), desc="Tokenizing"):
        tokens = tokenizer.encode(text, max_length=max_len, truncation=True)
        input_ids.append(tokens)
        attention_masks.append([1] * len(tokens))
        labels_classification.append(label_classification)
        labels_regression.append(label_regression)

    return input_ids, attention_masks, labels_classification, labels_regression

X_train_tokens, X_train_masks, y_train_classification, y_train_regression = tokenize_data_multitask(
    train_data["opinion"], train_data[["calificacion", "categoria"]], tokenizer
)
X_test_tokens, X_test_masks, y_test_classification, y_test_regression = tokenize_data_multitask(
    test_data["opinion"], test_data[["calificacion", "categoria"]], tokenizer
)

# Convertir a tensores de PyTorch
X_train_tensors = torch.tensor(X_train_tokens)
X_train_masks_tensors = torch.tensor(X_train_masks)
y_train_classification_tensors = torch.tensor(y_train_classification)
y_train_regression_tensors = torch.tensor(y_train_regression).unsqueeze(1)

X_test_tensors = torch.tensor(X_test_tokens)
X_test_masks_tensors = torch.tensor(X_test_masks)
y_test_classification_tensors = torch.tensor(y_test_classification)
y_test_regression_tensors = torch.tensor(y_test_regression).unsqueeze(1)

# Crear conjuntos de datos y dataloaders
train_dataset = TensorDataset(X_train_tensors, X_train_masks_tensors, y_train_classification_tensors, y_train_regression_tensors)
test_dataset = TensorDataset(X_test_tensors, X_test_masks_tensors, y_test_classification_tensors, y_test_regression_tensors)

train_dataloader = DataLoader(train_dataset, batch_size=8, shuffle=True)
test_dataloader = DataLoader(test_dataset, batch_size=8, shuffle=False)

# Configurar optimizadores y funciones de pérdida
classification_optimizer = torch.optim.AdamW(classification_model.parameters(), lr=2e-5)
regression_optimizer = torch.optim.AdamW(regression_model.parameters(), lr=2e-5)

classification_criterion = torch.nn.CrossEntropyLoss()
regression_criterion = torch.nn.MSELoss()

# Entrenar el modelo
num_epochs = 3

for epoch in range(num_epochs):
    classification_model.train()
    regression_model.train()
    total_classification_loss = 0
    total_regression_loss = 0

    for batch in tqdm(train_dataloader, desc=f"Epoch {epoch + 1}/{num_epochs}"):
        inputs, masks, labels_classification, labels_regression = batch

        # Entrenar el modelo de clasificación
        classification_optimizer.zero_grad()
        outputs_classification = classification_model(inputs, attention_mask=masks, labels=labels_classification)
        classification_loss = outputs_classification.loss
        total_classification_loss += classification_loss.item()
        classification_loss.backward()
        classification_optimizer.step()

        # Entrenar el modelo de regresión
        regression_optimizer.zero_grad()
        outputs_regression = regression_model(inputs, attention_mask=masks, labels=labels_regression.float())
        regression_loss = regression_criterion(outputs_regression.logits, labels_regression.float())
        total_regression_loss += regression_loss.item()
        regression_loss.backward()
        regression_optimizer.step()

    print(f"Epoch {epoch + 1}/{num_epochs}, Mean Classification Loss: {total_classification_loss / len(train_dataloader)}, Mean Regression Loss: {total_regression_loss / len(train_dataloader)}")

# Evaluar el modelo en el conjunto de prueba
classification_model.eval()
regression_model.eval()
predictions_classification = []
predictions_regression = []

with torch.no_grad():
    for batch in tqdm(test_dataloader, desc="Evaluating"):
        inputs, masks, labels_classification, labels_regression = batch

        # Predecir la clasificación
        outputs_classification = classification_model(inputs, attention_mask=masks)
        predictions_classification.extend(torch.argmax(outputs_classification.logits, dim=1).tolist())

        # Predecir la regresión
        outputs_regression = regression_model(inputs, attention_mask=masks)
        predictions_regression.extend(outputs_regression.logits.squeeze().tolist())

# Calcular la precisión en la clasificación y el error cuadrático medio en la regresión en el conjunto de prueba
accuracy = sum(y_test_classification == predictions_classification) / len(y_test_classification)
mse_regression = mean_squared_error(y_test_regression, predictions_regression)

print(f"Accuracy on Classification Task: {accuracy}")
print(f"Mean Squared Error on Regression Task: {mse_regression}")
