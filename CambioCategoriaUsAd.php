<?php
session_start();
include('Conexion.php');

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['Usuario'])) {
    $usuarioActual = $_SESSION['Usuario'];

    // Consultar la categoría del usuario actual en la base de datos
    $query = "SELECT Categoria FROM usuarios WHERE Usuario = '$usuarioActual'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        // Verificar si se obtuvo algún resultado
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $categoriaActual = $row['Categoria'];

            // Verificar la categoría para autorización
            if ($categoriaActual == 1) {
                // Consultar la lista de usuarios activos a cambiar la categoria de Usuario a Adm
                $queryUsuarios = "SELECT Usuario, Nombre, Apellido FROM usuarios WHERE Categoria = 0 AND Activo = 1";
                $resultUsuarios = mysqli_query($conexion, $queryUsuarios);
                ?>
                <!DOCTYPE html>
                <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Seleccionar Usuario para Cambiar a Administrador</title>
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
                            .containerNuevoUsuario{
                                display: flex;
                                justify-content: space-around;
                                width: 40%;
                                margin-left: 30%;
                                margin-top: 10%;
                                background-color: lightgoldenrodyellow;
                                padding: 1%;
                                position: relative; /* Hace que el contenedor sea relativo para que el mensaje de error pueda ser posicionado absolutamente */
                            }

                            .mensaje-error {
                                position: absolute;
                                top: -40px; /* Ajusta esta posición según sea necesario */
                                left: 50%; /* Centra el mensaje horizontalmente */
                                width:100%;
                                font-size: 20px;
                                transform: translateX(-50%); /* Centra el mensaje horizontalmente */
                                color: white;
                            }
                            .botones {
                                display: flex;
                                justify-content: space-between;
                                
                                margin-top: 10px; /* Ajusta el margen superior según sea necesario */
                            }
                            input[type="button"] {
                                margin-left: 15;
                            }
                                                  @media (min-width: 600px) and (max-width:1080px) {
                            .containerNuevoUsuario {
                                font-size:12px;
                                width: 40%;
                                margin-left: 30%;
                                }
                            }
                        @media (max-width:600px) {
                            .containerNuevoUsuario {
                                font-size:12px;
                                width: 60%;
                                margin-left: 20%;
                                }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="containerNuevoUsuario">
                            <?php if (isset($error)) : ?>
                                <div class="mensaje-error" style="background-color:red;">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (isset($exito)) : ?>
                                <div class="mensaje-error" style="background-color:green;">
                                    <?php echo $exito; ?>
                                </div>
                            <?php endif; ?>
                            <form action="ProcesarCambioUsAd.php" method="post">
                                <h3 style="margin:auto;">Cambio de Usuario a Administrador</h3>
                                <br>
                                <select name="usuario">
                                    <?php
                                    while ($rowUsuario = mysqli_fetch_assoc($resultUsuarios)) {
                                        echo "<option value='".$rowUsuario['Usuario']."'>".$rowUsuario['Nombre']." ".$rowUsuario['Apellido']." (".$rowUsuario['Usuario'].")</option>";
                                    }
                                    ?>
                                </select>
                                <br>
                                <hr>
                                <div class="botones">
                                    <input type="submit" value="Cambio de Categoria">
                                    <input type="button" value="Volver" style="margin-left: 20%;" onclick="location.href='indexusuario.php';">
                                </div>
                            </form>
                        </div>    
                    </body>
                </html>
                <?php
            } else {
                ?>
                <!DOCTYPE html>
                <html lang="es">
                <head>
                    <title>Analisis de Satisfaccion</title>
                    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
                    <meta name="addsearch-category" content="Cursada de Redes en UB">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <script src="./../jquery-3.7.1.js"></script>
                    <style>
                        body {
                            background-image: url('./EstacionDeServiciov.jpg');
                            background-size: cover;
                            background-repeat: no-repeat;
                        }

                        .headings-container {
                            background-color: red;
                            width: 30%;
                            margin-left: 50%;
                            text-align: center;
                            border-radius: 10px;
                            position: absolute; /* Posición absoluta */
                            top: 50%; /* Centrar verticalmente */
                            left: 0; /* Centrar horizontalmente */
                            transform: translate(-50%, -50%); /* Centrar exactamente */
                            padding: 20px; /* Espacio alrededor del mensaje */
                        }
                    </style>
                </head>
                <body>
                    <div class="headings-container">
                        <h3>Usuario no Autorizado!!!</h3>
                    </div>

                    <script>
                        // Espera un segundo y redirecciona al programa anterior
                        setTimeout(function() {
                            window.location.href = 'indexusuario.php';
                        }, 1000); // 1000 milisegundos = 1 segundo
                    </script>
                </body>
                </html>
                <?php
            }
        } else {
            echo "No se encontró información para el usuario actual.";
        }
    } else {
        echo "Error en la consulta: " . mysqli_error($conexion);
    }
} else {
    // El usuario no ha iniciado sesión, redirigir o realizar alguna acción
    header("Location: indexusuario.php"); // Redirige a la página de inicio de sesión, por ejemplo
    exit();
}
// Cierra la conexión a la base de datos si es necesario
mysqli_close($conexion);
?>
