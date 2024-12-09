<?php
include('verifSesion.inc');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Satisfacción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            background-image: url('./EstacionDeServiciov.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .estacion {
            margin: 5%;
            padding: 5%;
            background-color: lightblue;
        }
        .mi-boton {
            display: inline-flex;
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            text-decoration: none;
        }
        .mi-boton:hover {
            background-color: #3498db;
        }
        @media only screen and (max-width: 768px) {
            .estacion {
                margin: 2%;
                padding: 3%;
            }
        }
    </style>
</head>
<body>
    <div class="estacion">
        <?php
        function generateReport($conn, $column, $title) {
            $sql = "SELECT COUNT(*) as count, $column FROM opinion300 WHERE $column BETWEEN 1 AND 5 GROUP BY $column";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $total = 0;
                $data = array();

                while ($row = mysqli_fetch_assoc($result)) {
                    $conteo = $row['count'];
                    $total += $conteo;
                    $data[$row[$column]] = $conteo;
                }

                $etiquetas = array("Mala", "Regular", "Buena", "Muy Buena", "Excelente");

                echo "<h2>$title</h2>";

                foreach ($data as $calificacion => $conteo) {
                    $porcentaje = ($conteo / $total) * 100;
                    $porcentajeFormateado = number_format($porcentaje, 2);
                    $indice = $calificacion - 1;
                    echo "$etiquetas[$indice]: $porcentajeFormateado%<br>";
                }
            } else {
                echo "Error al ejecutar la consulta: " . mysqli_error($conn);
            }
        }

        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "u919161175_lnwqi";
        $conn = mysqli_connect($host, $user, $pass, $db);

        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        echo '<div id="modal1">';
        generateReport($conn, 'Modelo1', 'Informe de Satisfacción Epoch1 Pérdida: 0.802, Certeza: 0.71');
        echo '</div>';

        echo '<div id="modal2">';
        generateReport($conn, 'Modelo5', 'Informe de Satisfacción Epoch5 Pérdida: 0.151, Certeza: 0.9538');
        echo '</div>';

        echo '<div id="modal3">';
        generateReport($conn, 'Modelo10', 'Informe de Satisfacción Epoch10 Pérdida: 0.00984, Certeza: 0.9964');
        echo '</div>';
        mysqli_close($conn);
        ?>
        <br><br>
        <a href="explicacion.php" class="mi-boton" style="margin:auto;text-align:center;">Volver</a>
        <a href="indexconsultaVariasGraficos.php" class="mi-boton" style="margin:auto;text-align:center;">Gráficos</a>
        <br><br>
    </div>
</body>
</html>
