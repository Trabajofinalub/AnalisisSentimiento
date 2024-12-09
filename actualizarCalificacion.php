<?php
// Conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db = "id21470667_sentimientos";

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos enviados por AJAX
$id_opinion = $_POST['id_opinion'];
$calificacion = $_POST['calificacion'];

// Actualizar la calificación en la base de datos
$sql_update = "UPDATE pocasopiniones SET Modelo1 = ? WHERE IdOpinion = ?";
$stmt = $conn->prepare($sql_update);
$stmt->bind_param("ii", $calificacion, $id_opinion);

$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['message'] = 'Calificación actualizada correctamente';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error al actualizar la calificación: ' . $stmt->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
