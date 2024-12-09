<?php
include ('verifSesion.inc');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Análisis de Satisfacción</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="./jquery-3.7.1.js"></script>
    <style>
        body {
            background-image: url('./EstacionDeServiciov.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .headings-container {
            background-color: rgba(173, 216, 230, 0.8);
            width: 80%;
            margin: 5% auto;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        }

        .botones {
            display: flex;
            justify-content: center; /* Centra los botones horizontalmente */
            gap: 5px; /* Añade separación de 5px entre botones */
            width: 100%;
            margin: 20px auto;
        }

        .mi-boton {
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            height: 45px;
           
            text-align: center;
            border: none;
            cursor: pointer;
            width: 15%;
            border-radius: 10px;
            text-decoration: none;
            font-size: 16px;
        }

        .mi-boton:hover {
            background-color: #3498db;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            text-align: justify;
            color: #333;
        }
       @media only screen and (max-width: 900px) {
        .mi-boton {
            height: 85px;
                }
        }
    </style>
</head>
<body>

    <div class="headings-container">
        <h1>Análisis de Satisfacción del Modelo</h1>
        <p>
            El programa realiza una calificación cuantitativa de una opinión utilizando un modelo 
            preentrenado a través de un script en Python (<code>beto.py</code>). Este emplea diversas 
            bibliotecas, como <strong>pandas</strong>, <strong>torch</strong>, <strong>Transformers</strong>, y 
            <strong>sklearn.model</strong>.
        </p>
        <p>
            Durante el proceso, se entrena un modelo con una base de datos de opiniones, evaluando 
            su rendimiento en varias iteraciones (<em>epochs</em>). A medida que se aumenta el número 
            de iteraciones, el modelo mejora en precisión (<strong>exactitud</strong>) y reduce la 
            <strong>pérdida</strong>. 
        </p>
        <p>
            Se observa una notable mejoría en estos valores entre la primera y la quinta iteración, 
            mientras que entre la quinta y la décima no se perciben cambios sustanciales.
        </p>
        <p>
            Se agregan tres accesos para reentrenar el modelo para el caso que se amplie la base de datos de entrenamiento (opinion300).
            Cuando se califica una opinión se utiliza el modelo preentrenado de 10 Epoch (iteraciones) y se guarda en la base de datos "opinion"
        </p>
        <div class="botones">
            <a href="indexconsultaVarias.php" class="mi-boton">Ver Informe</a>
            <a href="indexconsultaVariasGraficos.php" class="mi-boton">Ver Gráficos</a>
            <a href="explicacion2.php" class="mi-boton">Conceptos de Entrenamiento y Validación</a>
            <a href="indexusuario.php" class="mi-boton">Volver</a>
        </div>
    </div>

</body>
</html>
