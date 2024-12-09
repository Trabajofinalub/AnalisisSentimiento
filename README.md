# Analisis de Sentimientos
Universidad de Belgrano

Proyecto de Laboratorio

Parametrización numérica de Opiniones

El programa realiza una calificación cuantitativa de una opinión utilizando un modelo preentrenado a través de un script en Python (desarrollado a partir de beto.py). Este emplea diversas bibliotecas, como pandas, torch, Transformers, y sklearn.model.

Durante el proceso, se entrena un modelo con una base de datos de opiniones, evaluando su rendimiento en varias iteraciones (epochs). A medida que se aumenta el número de iteraciones, el modelo mejora en precisión (exactitud) y reduce la pérdida. 

Se observa una notable mejoría en estos valores entre la primera y la quinta iteración, mientras que entre la quinta y la décima no se perciben cambios sustanciales.

Se agregan tres accesos con entrenamientos de 1 epoch, 5 epochs y 10 Epochs para reentrenar el modelo para el caso que se amplie la base de datos de entrenamiento (opinion300).

Cuando se califica una opinión se utiliza el modelo preentrenado de 10 Epoch (iteraciones) y se guarda en la base de datos "opinion"

Se ha observado una diferencia entre la certeza obtenida durante el entrenamiento y la obtenida al calificar usando el modelo preentrenado. Esto se debe a que la diversidad de vocabulario utilizado durante el entrenamiento es muy pobre. Para mejorar el mismo habría que ampliar la base de datos de entrenamiento para lo cual se tendría que contar con recursos informáticos superiores.

El listado de programa desarrollados es el siguiente:

Inicio.php

***Mantenimiento** (Icono de Herramienta)*

Index.php   
IniciarSesion.php  
indexUsuario.php  
**Consultas Varias** \-\> IndexConsultasVarias.php  
**Entrenar el Mode**lo \-\> llamadoEntrenamiento.php  
**Administración de Usuario**  
		NuevoUsuario.php \-\> indexUsuario.php  
		BajaUsuario.php \-\> procesarBaja.php \-\> indexUsuario.php  
		ActivarUsuario.php \-\> procesarActivacion.php \-\> indexUsuario.php  
		CambioCategoriaUsAd.php \-\> procesarCambioUsAd.php \-\> indexUsuario.php  
		CambioCategoriaAdUs.php \-\> procesarCambioAdUs.php \-\> indexUsuario.php  
		LimpiarPassword.php \-\> reemplazarPassword.php \-\> indexUsuario.php  
**Cambio de Password** CambioPassword.php \-\> indexUsuario.php  
**Análisis de Pérdida de exactitud**  
	CalificacionModelo1.php \-\> llamadoCalificacion1.php \-\> betoInferencia1.py \-\> actualizarCalificacion1.php  
							\-\> indexUsuario.php   
	CalificacionModelo5.php \-\> llamadoCalificacion5.php \-\> betoInferencia5.py \-\> actualizarCalificacion5.php  
							\-\> indexUsuario.php   
	CalificacionModelo10.php \-\> llamadoCalificacion10.php \-\> betoInferencia10.py \-\> actualizarCalificacion10.php  
							\-\> indexUsuario.php 

**Cerrar Sesión** CerrarSesion.php \-\> inicio.php

***Cargar Opinión*** 

cargaOpinion.php \-\> llamadoCalificacion.php \-\> betoInferencia.py \-\> altaOpinion.php \-\> (1)

**Programas utilizados por los diversos programas mencionados**

Conexión.php  
VerifSesion.inc
