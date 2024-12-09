import sys

import json
import torch
from transformers import BertTokenizer, BertForSequenceClassification
import os



class OpinionClassifier:
    def __init__(self, model_path, max_len=200):
        self.device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")
        self.max_len = max_len

        # Cargar el modelo preentrenado
        self.model = BertForSequenceClassification.from_pretrained("dccuchile/bert-base-spanish-wwm-cased", num_labels=5)
        self.model.to(self.device)

        # Cargar el modelo entrenado si está disponible
        if os.path.exists(model_path):
            state_dict = torch.load(model_path, map_location=self.device)
            
            # Filtrar las claves del estado del modelo preentrenado que coinciden con las claves del modelo de clasificación
            state_dict = {k: v for k, v in state_dict.items() if k in self.model.state_dict()}
            
            # Cargar el estado del modelo
            self.model.load_state_dict(state_dict, strict=False)
         #   print(f"Modelo cargado desde {model_path}")
        else:
            print(f"No se encontró el archivo {model_path}. Asegúrate de haber entrenado el modelo.")

        # Inicializar el tokenizador
        self.tokenizer = BertTokenizer.from_pretrained("dccuchile/bert-base-spanish-wwm-cased")

    def classify_sentiment(self, review_text):
        encoding_review = self.tokenizer.encode_plus(
            review_text,
            max_length=self.max_len,
            truncation=True,
            add_special_tokens=True,
            return_token_type_ids=False,
            pad_to_max_length=True,
            return_attention_mask=True,
            return_tensors='pt'
        )

        input_ids = encoding_review['input_ids'].to(self.device)
        attention_mask = encoding_review['attention_mask'].to(self.device)
        output = self.model(input_ids, attention_mask)
        _, prediction = torch.max(output.logits, dim=1)

        return {'classification': prediction.item() + 1}  # Sumar 1 para obtener la clasificación en lugar de la etiqueta


if __name__ == "__main__":
    # Ruta del modelo entrenado
    model_path = 'modelo_entrenado1.pth'

    # Crear una instancia del clasificador de opiniones
    opinion_classifier = OpinionClassifier(model_path)

    # Obtener el texto de la revisión del argumento de línea de comandos
    if len(sys.argv) > 1:
        review_text = sys.argv[1]
    else:
        print("Error: No se proporcionó texto de revisión.")
        sys.exit(1)

    # Ejecutar la clasificación y imprimir el resultado en formato JSON
    result = opinion_classifier.classify_sentiment(review_text)
    print(json.dumps(result))
