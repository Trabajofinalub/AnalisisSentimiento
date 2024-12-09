<?php
session_start();
include('Conexion.php');

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['Usuario'])) {
    $usuarioActual = $_SESSION['Usuario'];

    // Consultar la categoría del usuario actual en la base de datos
    $query = "SELECT Categoria FROM Usuarios WHERE Usuario = '$usuarioActual'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        // Verificar si se obtuvo algún resultado
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $categoriaActual = $row['Categoria'];

            // Verificar la categoría para autorización
            if ($categoriaActual == 1) {
                // Verificar si se ha enviado el formulario
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Obtener el usuario seleccionado del formulario
                    $usuarioSeleccionado = $_POST['usuario'];

                    // Cambiar la contraseña del usuario seleccionado
                    $nuevaPassword = "Password"; // La nueva contraseña
                    $nuevaPassword = md5($nuevaPassword);
                    $queryCambiarPassword = "UPDATE Usuarios SET Clave = '$nuevaPassword' WHERE Usuario = '$usuarioSeleccionado'";
                    $resultCambiarPassword = mysqli_query($conexion, $queryCambiarPassword);

                    if ($resultCambiarPassword) {
                        // Éxito al cambiar la contraseña
                        $exito = "La contraseña del usuario \"$usuarioSeleccionado\" ha sido cambiada correctamente.";
                    } else {
                        // Error al cambiar la contraseña
                        $error = "Error al cambiar la contraseña del usuario.";
                    }
                }
            } else {
                // El usuario no está autorizado
                $error = "El usuario actual no está autorizado para realizar esta acción.";
            }
        } else {
            $error = "No se encontró información para el usuario actual.";
        }
    } else {
        $error = "Error en la consulta: " . mysqli_error($conexion);
    }
} else {
    // El usuario no ha iniciado sesión, redirigir o realizar alguna acción
    header("Location: indexusuario.php"); // Redirige a la página de inicio de sesión, por ejemplo
    exit();
}

// Cierra la conexión a la base de datos si es necesario
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Cambio de Contraseña</title>
    <style>
        body {
            background-image: url('./EstacionDeServiciov.jpg');
            background-size: cover; /* Esto ajustará la imagen al tamaño de la ventana del navegador */
            background-repeat: no-repeat; /* Esto evitará que la imagen de fondo se repita */
        }
        .headings-container{
            background-color:lightblue;;
            width: 30% ;
            margin-left:50%;
            text-align:center;
            border-radius: 10px;
        }
        .mensaje{
           
            justify-content: space-around;

            width: 30%;
            margin-left: 43%;
            margin-top: 10%;
            background-color: lightgoldenrodyellow;
            padding: 1%;
            position: relative; /* Hace que el contenedor sea relativo para que el mensaje de error pueda ser posicionado absolutamente */
        }
        .exito {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="mensaje">
        <?php
        if (isset($exito)) {
            echo "<p class='exito'>$exito</p>";
        } elseif (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>
        <br>
        <hr>
        <a href="indexusuario.php">Volver</a>
    </div>
</body>
</html>
