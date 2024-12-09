<?php

$review_text = isset($_POST['review_text']) ? $_POST['review_text'] : '';

// Verificar si se proporcionó el texto de la revisión
if (empty($review_text)) {
    echo json_encode(['error' => 'No se proporcionó texto de revisión']);
    exit;
}

// Recibir datos del JSON
//$data = json_decode(file_get_contents('php://input'), true);

// Obtener el comentario del JSON

error_log("Review Text: $review_text");

// Verificar la ruta del script Python
$script_path = "./betoInferencia5.py";

if (!file_exists($script_path)) {
    echo json_encode(['error' => 'El script Python no existe']);
} else {
    try {
        // Ejecutar el script Python
        $output = shell_exec("python $script_path \"$review_text\"");

        // Verificar si hubo algún error en la salida del script Python
        if (strpos($output, 'Error') !== false) {
            // Manejar el error
            echo json_encode(['error' => 'Error en el script Python']);
        } else {
            // Imprimir la salida del script y cualquier error (opcional)
            error_log("Salida del script Python: $output");

            // Decodificar la salida JSON del script Python
            $result = json_decode($output, true);

            // Devolver la clasificación como respuesta
            header('Content-Type: application/json');
            echo json_encode(['classification' => $result['classification']]);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error al ejecutar el script Python']);
    }
}
?>
