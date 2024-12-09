<?php
header('Access-Control-Allow-Origin: *');
include('./Conexion.php'); // Asegúrate de que esta inclusión esté correcta y que las variables necesarias estén definidas.

$respuesta_estado = "";

try {
    $dsn = "mysql:host=$host;dbname=$dbname";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura el modo de error para lanzar excepciones.
    $respuesta_estado .= "\nConexion exitosa";
} catch (PDOException $e) {
    $respuesta_estado .= "\nError de conexión: " . $e->getMessage();
    echo $respuesta_estado;
    exit(); // Sale del script si hay un error de conexión.
}

$datos_json = json_decode($_GET['datos'], true);

$nuevaOpinion = $datos_json['nuevaOpinion'];
$calificacion = $datos_json['calificacion'];
$calificacionModelo = $datos_json['calificacionModelo'];
$fechaOpinion = $datos_json['fechaOpinion'];

$sql = "INSERT INTO u919161175_lnwqi.Opinion (Opiniones, Estrellas, CalifModelo,FechaOpinion) VALUES (:nuevaOpinion, :calificacion, :calificacionModelo, :fechaOpinion)";

try {
    $stmt = $dbh->prepare($sql);

    // Asigna los valores a los parámetros
    $stmt->bindParam(':nuevaOpinion', $nuevaOpinion, PDO::PARAM_STR);
    $stmt->bindParam(':calificacion', $calificacion, PDO::PARAM_INT);
    $stmt->bindParam(':calificacionModelo', $calificacionModelo, PDO::PARAM_INT);
    $stmt->bindParam(':fechaOpinion', $fechaOpinion, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $respuesta_estado .= "\nGracias por su opinión";
     
    } else {
        $respuesta_estado .= "\nError en la inserción: " . implode(", ", $stmt->errorInfo());
    }
} catch (PDOException $e) {
    $respuesta_estado .= "\nError en la ejecución de la consulta: " . $e->getMessage();
}

echo $respuesta_estado;

