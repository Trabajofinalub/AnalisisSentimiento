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
                // Consultar la lista de usuarios para dar de baja
                $queryUsuarios = "SELECT Usuario, Nombre, Apellido FROM usuarios WHERE Activo = 1 AND Usuario != '$usuarioActual'";
                $resultUsuarios = mysqli_query($conexion, $queryUsuarios);
                ?>
                <!DOCTYPE html>
                <html lang="es">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Seleccionar Usuario para Baja</title>
                        <style>
                                body {
                                    background-image: url('./EstacionDeServiciov.jpg');
                                    background-size: cover;
                                    background-repeat: no-repeat;
                                    display: flex;
                                    flex-direction: column; /* Coloca los elementos en una columna */
                                    justify-content: flex-start; /* Alinea los elementos al principio */
                                    align-items: center; /* Centra los elementos horizontalmente */
                                    height: 100vh;
                                    margin: 0;
                                    padding-top: 10%; /* Agrega un espacio desde la parte superior */
                                    }   

                                .full-screen-image {
                                    width: 100%;
                                    height: 100vh;
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
                                width: 20%;
                                margin-left: 43%;
                                margin-top: 20%;
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
                            input[type="button"] {
                                margin-left: 5%;
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
                            <form action="ProcesarBaja.php" method="post">
                                <h3 style="margin:auto;">Baja de Usuario</h3>
                                <br>
                                <select name="usuario">
                                    <?php
                                    while ($rowUsuario = mysqli_fetch_assoc($resultUsuarios)) {
                                        echo "<option value='".$rowUsuario['Usuario']."'>".$rowUsuario['Usuario']." - ".$rowUsuario['Nombre']." ".$rowUsuario['Apellido']."</option>";
                                    }
                                    ?>
                                </select>
                                <br>
                                <hr>
                                <div class="botones">
                                    <input type="submit" value="Baja Usuario">
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
            display: flex;
            flex-direction: column; /* Coloca los elementos en una columna */
            justify-content: flex-start; /* Alinea los elementos al principio */
            align-items: center; /* Centra los elementos horizontalmente */
            height: 100vh;
            margin: 0;
            padding-top: 10%; /* Agrega un espacio desde la parte superior */
            }   

        .full-screen-image {
            width: 100%;
            height: 100vh;
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
