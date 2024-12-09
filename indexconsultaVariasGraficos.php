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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js -->
    <style>
        body {
            background-image: url('./EstacionDeServiciov.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }
        .estacion {
            margin: 5%;
            padding: 1%;
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

        /* Flexbox para alinear gráficos */
        .contenedor-graficos {
            display: flex;
            justify-content: space-around; /* Espacio entre los gráficos */
            align-items: center;
            flex-wrap: wrap; /* Permite que los gráficos se reorganicen en pantallas pequeñas */
            margin-top: 5px; /* Ajusta el margen superior aquí */
        }

        /* Estilos específicos para cada modal para mejorar la presentación */
        .grafico-modal {
            margin: 10px;
            text-align: center;
        }

        @media only screen and (max-width: 768px) {
            .estacion {
                margin: 2%;
                padding: 3%;
            }

            /* Ajustar la dirección de los gráficos en pantallas pequeñas */
            .contenedor-graficos {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="estacion">
        <?php
        function generateReport($conn, $column) {
            $sql = "SELECT COUNT(*) as count, $column FROM opinion300 WHERE $column BETWEEN 1 AND 5 GROUP BY $column";
            $result = mysqli_query($conn, $sql);

            $data = array();
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $conteo = $row['count'];
                    $data[$row[$column]] = $conteo;
                }
            } else {
                echo "Error al ejecutar la consulta: " . mysqli_error($conn);
            }
            return $data;
        }

        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "u919161175_lnwqi";
        $conn = mysqli_connect($host, $user, $pass, $db);

        if (!$conn) {
            die("Conexión fallida: " . mysqli_connect_error());
        }

        // Obtener los datos para cada gráfico
        $data1 = generateReport($conn, 'Modelo1');
        $data5 = generateReport($conn, 'Modelo5');
        $data10 = generateReport($conn, 'Modelo10');

        mysqli_close($conn);
        ?>
        <!-- Contenedor de gráficos en formato flex -->
        <div class="contenedor-graficos">
            <div class="grafico-modal">
                <h2>Informe de Satisfacción Epoch1</h2>
                <canvas id="graficoTortaModal1" width="200" height="200"></canvas>
            </div>

            <div class="grafico-modal">
                <h2>Informe de Satisfacción Epoch5</h2>
                <canvas id="graficoTortaModal5" width="200" height="200"></canvas>
            </div>

            <div class="grafico-modal">
                <h2>Informe de Satisfacción Epoch10</h2>
                <canvas id="graficoTortaModal10" width="200" height="200"></canvas>
            </div>
            <div class="grafico-modal">
                <a href="explicacion.php" class="mi-boton" style="margin:auto;text-align:center;">Volver</a>            
            </div>
        </div>

        <script>
            // Función para crear gráficos de torta
            function crearGraficoTorta(idCanvas, data) {
                var ctx = document.getElementById(idCanvas).getContext('2d');
                var chartData = {
                    labels: ['Mala', 'Regular', 'Buena', 'Muy Buena', 'Excelente'],
                    datasets: [{
                        label: 'Opiniones',
                        data: data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                };

                new Chart(ctx, {
                    type: 'pie',
                    data: chartData,
                    options: {
                        responsive: false // Evita que el gráfico se redimensione automáticamente
                    }
                });
            }

            // Convertir los datos PHP a un formato de JavaScript
            var data1 = [<?php echo implode(',', $data1); ?>];
            var data5 = [<?php echo implode(',', $data5); ?>];
            var data10 = [<?php echo implode(',', $data10); ?>];

            // Crear los gráficos
            crearGraficoTorta('graficoTortaModal1', data1);
            crearGraficoTorta('graficoTortaModal5', data5);
            crearGraficoTorta('graficoTortaModal10', data10);
        </script>


    </div>
</body>
</html>
