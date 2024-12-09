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
            justify-content: center;
            gap: 5px;
            width: 100%;
            margin: 20px auto;
        }

        .mi-boton {
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            height: 25px;
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

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #333;
        }

        th {
            padding: 1px;
            text-align: left;
        }
       td {
            padding: 1px;
            text-align: center;
        }
        th {
            background-color: #2980b9;
            color: white;
        }

        td {
            background-color: #f2f2f2;
        }

        p {
            font-size: 18px;
            line-height: 1.6;
            text-align: justify;
            color: #333;
        }
  
    </style>
</head>
<body>

    <div class="headings-container">
        <h1>Explicación de Entrenamiento y Validación</h1>
        <p>
            En el análisis de satisfacción al entrenar un modelo, como BERT, los términos pérdida (loss) y exactitud (accuracy) son métricas clave para evaluar el rendimiento del modelo.
    </p>
    <p>
            <strong>Pérdida (Loss) en el entrenamiento:</strong> La pérdida mide qué tan bien o mal está funcionando el modelo durante el entrenamiento. En otras palabras, indica qué tan lejos están las predicciones del modelo de las etiquetas correctas. El objetivo del proceso de entrenamiento es minimizar esta pérdida. Durante el entrenamiento, el modelo ajusta sus parámetros para reducir este valor, acercando sus predicciones a las etiquetas correctas. Un valor de pérdida bajo significa que el modelo está funcionando bien. Un valor de pérdida alto indica que el modelo tiene dificultades para aprender o que está haciendo malas predicciones.
            </p>
            <p>
            <strong>Exactitud (Accuracy) en el entrenamiento:</strong> La exactitud mide el porcentaje de predicciones correctas del modelo en el conjunto de datos. Representa la proporción de instancias en que las predicciones del modelo coinciden con las etiquetas verdaderas. Una exactitud alta significa que el modelo está haciendo bien sus predicciones. Una exactitud baja sugiere que el modelo no está prediciendo correctamente la mayoría de los casos.
            </p>
            <p>
            Por ejemplo, si al final de un epoch (una pasada completa a través del conjunto de datos) se tiene una pérdida baja y una exactitud alta, significa que el modelo está aprendiendo correctamente y es preciso. Si tienes una pérdida alta y una exactitud baja, puede ser que el modelo esté subentrenado o necesite más ajustes.

            </p>
    <p>
            <strong>Pérdida y Exactitud en la validación:</strong> En la validación de un modelo, como el entrenamiento, también se utilizan las métricas de pérdida (loss) y exactitud (accuracy) para evaluar su rendimiento. Sin embargo, estas métricas se calculan en un conjunto de datos de validación, separado del conjunto de datos de entrenamiento, para verificar si el modelo está generalizando bien. Vamos a ver cada una de ellas:

           </p>
           <p>
            <strong>Pérdida en la validación:</strong> Es una medida de cuán bien el modelo predice en datos que no ha visto antes, es decir, en el conjunto de validación. Se utiliza para verificar si el modelo está aprendiendo patrones que se generalicen a datos nuevos y no solo memoriza los datos de entrenamiento. Si la pérdida en validación es baja y sigue disminuyendo a lo largo de las épocas, significa que el modelo se está generalizando bien. Si la pérdida en validación es significativamente mayor que la pérdida en el entrenamiento, puede ser una señal de sobreajuste (overfitting), lo que significa que el modelo está ajustando demasiado bien los datos de entrenamiento, pero no funciona bien en datos nuevos.
            </p>
            <p>
            <strong>Exactitud en la validación:</strong> Mide el porcentaje de predicciones correctas del modelo en el conjunto de validación. Como con la pérdida, se utiliza para medir qué tan bien se está generalizando el modelo en datos no vistos. Una exactitud en validación que es cercana a la exactitud de entrenamiento indica que el modelo está generalizando bien. Si la exactitud en validación es mucho menor que la exactitud en entrenamiento, esto puede sugerir sobreajuste, lo que significa que el modelo ha aprendido patrones específicos de los datos de entrenamiento que no se aplican a datos nuevos.
            </p>
            <p>
            <strong>Comparación entre entrenamiento y validación:</strong> Durante el entrenamiento se espera que tanto la pérdida como la exactitud en el conjunto de entrenamiento mejoren con el tiempo. En el conjunto de validación, se espera ver una tendencia similar, pero en muchos casos, la pérdida de validación puede dejar de disminuir o incluso aumentar si el modelo empieza a sobreajustarse a los datos de entrenamiento. La validación te ayuda a medir cómo de bien funcionará el modelo cuando se enfrente a datos del "mundo real", y te advierte si tu modelo se está ajustando demasiado a los datos de entrenamiento.
        </p>
               <!-- Inserción de la tabla -->
        <table>
            <thead>
                <tr>
                    <th>Epoch</th>
                    <th>Pérdida Entrenam.</th>
                    <th>Exactitud Entrenam.</th>
                    <th>Pérdida Valid.</th>
                    <th>Exactitud Valid.</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>1.0906</td><td>0.6748</td><td>0.9213</td><td>0.7073</td></tr>
                <tr><td>2</td><td>0.6529</td><td>0.7791</td><td>0.5818</td><td>0.8049</td></tr>
                <tr><td>3</td><td>0.5345</td><td>0.7975</td><td>1.1959</td><td>0.7317</td></tr>
                <tr><td>4</td><td>0.6374</td><td>0.8344</td><td>0.7301</td><td>0.6829</td></tr>
                <tr><td>5</td><td>0.3154</td><td>0.9080</td><td>0.5801</td><td>0.7805</td></tr>
                <tr><td>6</td><td>0.1435</td><td>0.9755</td><td>0.6962</td><td>0.7317</td></tr>
                <tr><td>7</td><td>0.0674</td><td>0.9877</td><td>0.7878</td><td>0.7805</td></tr>
                <tr><td>8</td><td>0.0447</td><td>0.9877</td><td>0.9301</td><td>0.7073</td></tr>
                <tr><td>9</td><td>0.0521</td><td>0.9877</td><td>0.9204</td><td>0.7073</td></tr>
                <tr><td>10</td><td>0.0225</td><td>0.9939</td><td>1.0575</td><td>0.6829</td></tr>
                <tr><td>11</td><td>0.0177</td><td>0.9939</td><td>1.1107</td><td>0.6829</td></tr>
                <tr><td>12</td><td>0.0149</td><td>0.9939</td><td>1.1261</td><td>0.6829</td></tr>
                <tr><td>13</td><td>0.0137</td><td>0.9939</td><td>1.1378</td><td>0.6829</td></tr>
                <tr><td>14</td><td>0.0136</td><td>0.9939</td><td>1.1417</td><td>0.6829</td></tr>
                <tr><td>15</td><td>0.0131</td><td>0.9939</td><td>1.1406</td><td>0.6829</td></tr>
                <tr><td>16</td><td>0.0116</td><td>0.9939</td><td>1.1454</td><td>0.7073</td></tr>
                <tr><td>17</td><td>0.0112</td><td>0.9939</td><td>1.1488</td><td>0.7073</td></tr>
                <tr><td>18</td><td>0.0132</td><td>0.9877</td><td>1.1499</td><td>0.7073</td></tr>
                <tr><td>19</td><td>0.0105</td><td>0.9939</td><td>1.1515</td><td>0.7073</td></tr>
                <tr><td>20</td><td>0.0109</td><td>0.9939</td><td>1.1523</td><td>0.7073</td></tr>
            </tbody>
        </table>
    <p>
        En los datos se observa que los resultados del entrenamiento son muy buenos, pero en la valición la exactitud cae al 0,7.
    </p>
    <p>    
        Esto se debe principalmente que durante el entrenamiento no se utilizan palabras que luego si se utilizan en la validación. Se podría mejorar ampliando la base de datos en el entrenamiento.
    </p>  
        <div class="botones">
             <a href="explicacion.php" class="mi-boton">Volver</a>
        </div>
    </div>

</body>
</html>
