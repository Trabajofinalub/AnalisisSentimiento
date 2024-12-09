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

// Validar que se reciben los datos esperados
if (isset($_POST['id_opinion'], $_POST['calificacion'])) {
    $id_opinion = $_POST['id_opinion'];
    $calificacion = $_POST['calificacion'];

    // Actualizar la calificación en la base de datos
    $sql_update = "UPDATE opinion300 SET Modelo1 = ? WHERE IdOpinion = ?";
    $stmt = $conn->prepare($sql_update);
    
    // Verificar el tipo de datos para el bind_param, asumiendo que ambos son enteros
    $stmt->bind_param("ii", $calificacion, $id_opinion);

    $response = array();
    
    // Ejecutar la actualización y verificar el éxito
    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Calificación actualizada correctamente';
    } else {
        // Mejor manejo de errores para evitar exposición de información sensible
        $response['status'] = 'error';
        $response['message'] = 'Error al actualizar la calificación.';
    }

    $stmt->close();
} else {
    // Error en caso de datos faltantes
    $response['status'] = 'error';
    $response['message'] = 'Datos incompletos recibidos.';
}

$conn->close();

// Cabecera para asegurar que se devuelve JSON
header('Content-Type: application/json');
echo json_encode($response);
?>