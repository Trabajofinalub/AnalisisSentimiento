<?php
include ('Conexion.php');
include ('verifSesion.inc');

$usuarioActual = $_SESSION['Usuario'];


if (isset($_POST['submit'])) {

    $nuevaClave1 = $_POST['nuevaClave1'];
    $nuevaClave2 = $_POST['nuevaClave2'];

    // Validar la nueva contraseña
        if ($nuevaClave1 === $nuevaClave2) {
            $nuevaClaveHash = md5($nuevaClave1); // Mismo método de hash usado al registrar la contraseña

            // Actualizar la contraseña en la base de datos
            $updateQuery = "UPDATE usuarios SET Clave = '$nuevaClaveHash' WHERE Usuario = '$usuarioActual'";
            $updateResult = mysqli_query($conexion, $updateQuery);

            if ($updateResult) {
                    $exito = "La contraseña del usuario ha sido cambiada correctamente.";
                    header("Location: MensajeOKpassword.php");
                } else {
                    $error = "Error al actualizar la contraseña: " . mysqli_error($conexion);
            }
        } else {
            $error = "Las contraseñas no coinciden.";
        }
    //}
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Cambiar Contraseña</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="./../jquery-3.7.1.js"></script>
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
        .containerNuevaPassword {
            display: flex;
            flex-direction: column; /* Cambia la dirección del flexbox a columna para alinear verticalmente */
            align-items: center; /* Centra los elementos verticalmente */
            width: 30%;
            margin-left: 40%;
            margin-top: 10%;
            background-color: lightgoldenrodyellow;
            padding: 1%;
            position: relative;
        }

        .mensaje-error {
            position: absolute;
            top: -40px; 
            left: 50%; /* Centra el mensaje horizontalmente */
            width:100%;
            font-size: 20px;
            transform: translateX(-50%); /* Centra el mensaje horizontalmente */
            color: white;
        }

        input[type="button"] {
            margin-left: 1%;
        }
        input[type="password"] {
            
            width: 40%; /* Ajusta el ancho de los campos de contraseña */
            margin-left: 40%; /* Agrega un margen uniforme para separar los campos */
        }
        input[type="password1"] {
            
            width: 30%; /* Ajusta el ancho de los campos de contraseña */
            margin-left: 1%; /* Agrega un margen uniforme para separar los campos */
        }
        @media (min-width: 600px) and (max-width:1080px) {
            .containerNuevaPassword {
                font-size:14px;
                width: 40%;
                margin-left: 30%;
                }
            }
        @media (max-width:600px) {
            .containerNuevaPassword {
                font-size:14px;
                width: 60%;
                margin-left: 20%;
                
                }
            input[type="button"] {
                margin-left: 1%;
                font-size: 12px;
        }
            input[type="submit"] {
                font-size: 12px;
        }
           input[type="password"] {
            margin-left: 30%; /* Agrega un margen uniforme para separar los campos */
            width: 50%; /* Ajusta el ancho de los campos de contraseña */
            
        }
            }
 </style>
</head>
<body> 
    <div class="containerNuevaPassword">
            <?php if (isset($error)) : ?>
            <div class="mensaje-error" style="background-color:red;"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if (isset($exito)) : ?>
            <div class="mensaje-error" style="background-color:green;"><?php echo $exito; ?></div>
            <?php
                endif; ?>            
        <form method="post" action="">
            <h3 style="margin:auto">Debe cambiar la Contraseña</h3>

            <label for="nuevaClave1">Nueva Contraseña:</label><br>
            <input type="password" name="nuevaClave1" id="nuevaClave1" required>
            <span class="toggle-password" onclick="togglePassword('nuevaClave1')"><i class="fas fa-eye"></i></span><br><br>
            
            <label for="nuevaClave2">Confirmar Nueva Contraseña:</label><br>
            <input type="password" name="nuevaClave2" id="nuevaClave2" required>
            <span class="toggle-password" onclick="togglePassword('nuevaClave2')"><i class="fas fa-eye"></i></span><br><br>

            <hr>
            
            <input type="submit" name="submit" value="Cambiar Contraseña";>
            <input type="button" value="Volver" onclick="location.href='CerrarSesion.php';">
        </form>
    </div>
</body>
        <script>
            function togglePassword(inputId) {
                var input = document.getElementById(inputId);
                var icon = input.nextElementSibling.querySelector("i");
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    input.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            }
</script>

</html>
