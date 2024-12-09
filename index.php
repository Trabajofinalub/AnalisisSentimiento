<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Satisfacción</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
        .headings-container {
            background-color: blue;
            width: 40%;
            margin-top: 1%;
            color: yellow;
            padding: 10px 20px;
            border: none;
            margin-left: 4%;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
        }
        .containerInicio {
            width: 90%;
            max-width: 400px;
            background-color: lightgoldenrodyellow;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px; /* Agrega espacio entre los contenedores */
        }
        .input-group {
            position: relative;
            margin-bottom: 1rem; /* Añade un espacio entre los campos */
        }
        #passwordInput {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        #togglePassword {
            z-index: 99;
            position: absolute;
            right: 0;
            top: 0;
            bottom: 0;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        @media (max-width:600px) {
        .headings-container {
            font-size:8px;
            width: 70%;
        }
        .h3 {
            font-size:8px;
            }
        .botones {
            width: 60%;
        }    
        }
    </style>
</head>
<body> 
<div class="headings-container">
        <h3>Evaluación de Satisfacción de Clientes</h3>
</div> 
    <div class="containerInicio">    
        <form action="IniciarSesion.php" method="POST">
            <h3 style='background-color:white'>Inicio de Sesión</h3>
            <?php
            if (isset($_GET['error'])) {
                echo '<p class="error">' . $_GET['error'] . '</p>';
            }
            ?>
            <div class="input-group">
                <input type="text" name="Usuario" class="form-control" placeholder="Nombre de Usuario">
            </div>
            <div class="input-group">
                <input type="password" name="Clave" id="passwordInput" class="form-control" placeholder="Clave">
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
            <div>
                <button type="submit" class="btn btn-primary btn-block">Ingresar Sesión</button>
                <a href="Inicio.php" class="btn btn-secondary btn-block">Volver</a>
            </div>
        </form>
    </div>

    <!-- JavaScript para cambiar dinámicamente el tipo de entrada -->
    <script>
        const togglePasswordButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');

        togglePasswordButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        });
    </script>
</body>
</html>
