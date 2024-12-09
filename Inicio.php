<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análisis de Satisfacción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

        .full-screen-image {
            width: 100%;
            height: 100vh;
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

        .botones {
            display: inline-flex;
            width: 20%;
            margin-top: 1%;
            margin-left: 10%;
        }

        .mi-boton {
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            
            border-radius: 10px;
            text-decoration: none;
        }

        .mi-boton:hover {
            background-color: #3498db;
        }

        /* Estilos para el botón de mantenimiento */
        .boton-mantenimiento {
            position: absolute;
            top: 10%; /* Ajuste del botón al 5% del borde superior */
            right: 5%; /* Ajuste del botón al 5% del borde derecho */
            background-color: #c0392b;
            padding: 10px;
            border-radius: 50%;
        }

        /* Estilos para el icono del botón de mantenimiento */
        .boton-mantenimiento i {
            color: white;
            font-size: 24px;
        }
        @media (max-width:800px) {
        .botones {
            width: 40%;
        }    
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
<div class="botones">
    <a href="CargaOpinion.php" class="mi-boton">Ingreso de Opinión</a>
    <!-- Cambiado el botón de Usuario por el botón de Mantenimiento con un icono -->
    <div class="boton-mantenimiento">
        <a href="indexusuario.php"><i class="fas fa-wrench"></i></a>
    </div>
</div>
</body>
</html>
