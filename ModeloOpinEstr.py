# Importar bibliotecas
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.linear_model import LinearRegression
from sklearn.metrics import mean_squared_error
from sklearn.pipeline import make_pipeline

# Leer los datos
# Asumamos que tienes un archivo CSV con dos columnas: "opinion" y "calificacion"
data = pd.read_csv("datos.csv")

# Dividir los datos en conjuntos de entrenamiento y prueba
X_train, X_test, y_train, y_test = train_test_split(data['opinion'], data['calificacion'], test_size=0.2, random_state=42)

# Crear un modelo de regresión lineal
model = make_pipeline(CountVectorizer(), LinearRegression())

# Entrenar el modelo
model.fit(X_train, y_train)

# Predecir las calificaciones en el conjunto de prueba
y_pred = model.predict(X_test)

# Evaluar el rendimiento del modelo
mse = mean_squared_error(y_test, y_pred)
print(f"Error cuadrático medio en el conjunto de prueba: {mse}")

# Utilizar el modelo entrenado para hacer predicciones
nueva_opinion = ["Esta aplicación es genial, fácil de usar."]
calificacion_predicha = model.predict(nueva_opinion)
print(f"La calificación predicha para la nueva opinión es: {calificacion_predicha[0]}")
