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
                // El usuario actual está autorizado

                // Consultar las categorías disponibles en la base de datos
                $queryCategorias = "SELECT IdCategoria, DescripcionCat FROM categoriausuario";
                $resultCategorias = mysqli_query($conexion, $queryCategorias);

                if (!$resultCategorias) {
                    $error = "Error al obtener las categorías: " . mysqli_error($conexion);
                }

                // Verificar si se está intentando agregar un nuevo usuario
                if (isset($_POST['submit'])) {
                    // Obtener los datos del formulario
                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];
                    $nuevoUsuario = $_POST['nuevoUsuario'];
                    $categoria = $_POST['categoria'];
                    $clave1 = $_POST['clave1'];
                    $clave2 = $_POST['clave2'];

                    // Verificar que las contraseñas sean iguales
                    if ($clave1 == $clave2) {
                        // Hash de la contraseña
                        $hashedClave = md5($clave1); // Se recomienda usar un método más seguro

                        // Insertar el nuevo usuario en la base de datos
                        $insertQuery = "INSERT INTO Usuarios (Nombre, Apellido, Usuario, Clave, Categoria, Activo)
                                        VALUES ('$nombre', '$apellido', '$nuevoUsuario', '$hashedClave', '$categoria', 1)";

                        $insertResult = mysqli_query($conexion, $insertQuery);

                        if ($insertResult) {
                            $exito = "Alta de usuario realizada";
                            header("Location: indexusuario.php");
                        } else {
                            $error = "Error al agregar el nuevo usuario: " . mysqli_error($conexion);
                        }
                    } else {
                        $error = "Las contraseñas no coinciden.";
                    }
                }
                ?>
                <!DOCTYPE html>
                <html lang="es">
                <head>
                    <title>Analisis de Satisfaccion</title>
                    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
                    <meta name="addsearch-category" content="Cursada de Redes en UB">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                    <script src="./jquery-3.7.1.js"></script>
                    <style>
                        body {
                            background-image: url('./EstacionDeServiciov.jpg');
                            background-size: cover;
                            background-repeat: no-repeat;
                        }

                        .headings-container {
                            background-color: lightblue;
                            width: 30%;
                            margin-left: 50%;
                            text-align: center;
                            border-radius: 10px;
                        }

                        .containerNuevoUsuario {
                            display: flex;
                            justify-content: space-around;
                            width: 20%;
                            margin-left: 43%;
                            margin-top: 10%;
                            background-color: lightgoldenrodyellow;
                            padding: 1%;
                            position: relative;
                        }

                        .mensaje-error {
                            position: absolute;
                            top: -40px;
                            left: 50%;
                            width: 100%;
                            font-size: 20px;
                            transform: translateX(-50%);
                            color: white;
                        }

                        input[type="button"] {
                            margin-left: 20%;
                        }
                        @media (min-width: 600px) and (max-width:1080px) {
                            .containerNuevoUsuario {
                                font-size:12px;
                                width: 40%;
                                margin-left: 30%;
                                }
                            input[type="button"] {
                                margin-left: 5%;
                            }        
                            }
                        @media (max-width:600px) {
                            .containerNuevoUsuario {
                                font-size:12px;
                                width: 60%;
                                margin-left: 10%;
                                }
                            input[type="button"] {
                                margin-left: 5%;
                            }    
                            }
                    </style>
                </head>
                <body>
                <div>
                    <div class="containerNuevoUsuario">
                        <?php if (isset($error)) : ?>
                            <div class="mensaje-error" style="background-color:red;"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <?php if (isset($exito)) : ?>
                            <div class="mensaje-error" style="background-color:green;"><?php echo $exito; ?></div>
                        <?php endif; ?>

                        <form method="post" action="" onsubmit="return validarFormulario();">
                            <h3 style="margin:auto;">Ingreso de Nuevo Usuario</h3>

                            <label for="nombre">Nombre:</label><br>
                            <input type="text" name="nombre" required><br>

                            <label for="apellido">Apellido:</label><br>
                            <input type="text" name="apellido" required><br>

                            <label for="nuevoUsuario">Nuevo Usuario:</label><br>
                            <input type="text" name="nuevoUsuario" required><br>

                            <label for="categoria">Categoría:</label><br>
                            <select name="categoria" required>
                                <?php while ($rowCategoria = mysqli_fetch_assoc($resultCategorias)) : ?>
                                    <option value="<?php echo $rowCategoria['IdCategoria']; ?>"><?php echo $rowCategoria['DescripcionCat']; ?></option>
                                <?php endwhile; ?>
                            </select><br>

                            <label for="clave1">Contraseña:</label><br>
                            <input type="password" name="clave1" id="clave1" required>
                            <span class="toggle-password" onclick="togglePassword('clave1')"><i class="fas fa-eye"></i></span><br>

                            <label for="clave2">Confirmar Contraseña:</label><br>
                            <input type="password" name="clave2" id="clave2" required>
                            <span class="toggle-password" onclick="togglePassword('clave2')"><i class="fas fa-eye"></i></span><br>
                            <hr>
                            <input type="submit" name="submit" value="Alta Usuario">
                            
                            <input type="button" value="Volver" onclick="location.href='indexusuario.php';">
                        </form>
                    </div>
                </div>

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

                    function validarFormulario() {
                        var clave1 = document.getElementById('clave1').value;
                        var clave2 = document.getElementById('clave2').value;

                        // Verificar que las contraseñas sean iguales
                        if (clave1 !== clave2) {
                            alert('Las contraseñas no coinciden. Por favor, inténtalo de nuevo.');

                            // Limpiar los campos de contraseña
                            document.getElementById('clave1').value = '';
                            document.getElementById('clave2').value = '';

                            // Poner el foco en el primer campo de contraseña
                            document.getElementById('clave1').focus();

                            // Evitar que el formulario se envíe
                            return false;
                        }

                        // Permitir que el formulario se envíe
                        return true;
                    }
                </script>
                </body>
                </html>

                <?php
            } else {
                // El usuario no está autorizado
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
    header("Location: indexusuario.php");
    exit();
}

// Cierra la conexión a la base de datos si es necesario
mysqli_close($conexion);
?>
