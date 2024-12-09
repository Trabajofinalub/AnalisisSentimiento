<?php
    $exito = "La contraseña ha sido actualizada.";
    $error = "La contraseña NO ha sido actualizada";
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
        <a href="indexusuario.php">Continuar</a>
    </div>
</body>
</html>
