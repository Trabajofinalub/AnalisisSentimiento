<?php
ini_set('max_execution_time', 600);  // 10 minutos

// Ruta al script de Python
$pythonScript = "beto.py";

// Verifica si el archivo del script de Python existe
if (file_exists($pythonScript)) {
    // Construye el comando para ejecutar el script de Python sin datos específicos
    $command = "python $pythonScript";

    // Ejecuta el comando
    exec($command, $output, $returnValue);

    // Verifica si el programa Python se ejecutó correctamente
    if ($returnValue === 0) {
        echo "<script>alert('El modelo se entrenó exitosamente.');</script>";
        echo "<script>window.location.href = 'indexusuario.php';</script>";
    } else {
        echo "<script>alert('Error al ejecutar el programa Python.');</script>";
        echo "<script>window.location.href = 'indexusuario.php';</script>";
    }
} else {
    echo "<script>alert('El archivo del script de Python no se encontró.');</script>";
    echo "<script>window.location.href = 'indexusuario.php';</script>";
}
?>
