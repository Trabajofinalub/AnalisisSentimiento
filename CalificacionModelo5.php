<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "u919161175_lnwqi";

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener las opiniones
$sql = "SELECT IdOpinion, Opiniones FROM opinion300";
$result = $conn->query($sql);

$opiniones = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $opiniones[] = $row;
    }
} else {
    echo "No se encontraron opiniones en la base de datos.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Analisis de Satisfacion</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="addsearch-category" content="Cursada de Redes en UB">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="./jquery-3.7.1.js"></script>
   
    <style>
        body {
            background-image: url('./EstacionDeServiciov.jpg');
            background-size: cover; /* Esto ajustará la imagen al tamaño de la ventana del navegador */
            background-repeat: no-repeat; /* Esto evitará que la imagen de fondo se repita */
        }
    </style>
</head>
<body> 

<!-- Tu contenido HTML aquí -->

<script>
    $(document).ready(function() {
        var opiniones = <?php echo json_encode($opiniones); ?>;
        var ajaxRequests = [];

        opiniones.forEach(function(opinion) {
            var request = $.ajax({
                type: "POST",
                url: "./llamadoCalificacion5.php",
                data: { review_text: opinion.Opiniones },
                dataType: "json"
            }).done(function(response) {
                if (response.classification) {
                    console.log("Calificación obtenida para la opinión: " + response.classification);

                    // Actualizar la calificación en la base de datos
                    $.ajax({
                        type: "POST",
                        url: "./actualizarCalificacion5.php",
                        data: { 
                            id_opinion: opinion.IdOpinion, 
                            calificacion: response.classification 
                        },
                        dataType: "json"
                    }).done(function(updateResponse) {
                        if (updateResponse.status === 'success') {
                            console.log("Calificación actualizada para la opinión con ID: " + opinion.IdOpinion);
                        } else {
                            console.error("Error al actualizar la calificación: " + updateResponse.message);
                        }
                    }).fail(function(xhr, status, error) {
                        console.error("Error en la solicitud AJAX para actualizar:", error);
                    });
                } else {
                    console.error("Error: No se recibió la clasificación del modelo.");
                }
            }).fail(function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
            });

            ajaxRequests.push(request);
        });

        $.when.apply($, ajaxRequests).done(function() {
            // Redirigir a indexUsuario.php cuando todas las solicitudes AJAX hayan terminado
            window.location.href = 'indexUsuario.php';
        });
    });
</script>

</body>
</html>
