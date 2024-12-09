<?php
include ('verifSesion.inc');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Analisis de Satisfaccion</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="./jquery-3.7.1.js"></script>
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
        .botones {
            display: flex;
            justify-content: space-around;
            width: 60%; 
            margin:auto;
            margin-top: 30%;
        }

        .mi-boton {
            display: inline-flex;
            background-color: #2980b9;
            color: white;
            margin: auto;
            padding: 10px 20px;
            height: 50px;
            width: 100%; 
            margin-left: 1%;
            text-align: center;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            text-decoration: none;
        }

        .mi-boton:hover {
            background-color: #3498db;
        }
        #modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 25%;
            height: 30%;
            font-size: 25px;
            transform: translate(-50%, -50%);
            background-color:lightblue;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .boton-modal {
            display: inline-flex;
            background-color: #2980b9;
            color: white;
            padding: 10px 20px;
            font-size: 15px;
            width: 150px; /* Cambié el ancho del botón a 100% */
            margin-left: 1%;
            text-align: center;
            border: none;
            cursor: pointer;
            border-radius: 10px;
            text-decoration: none;
        }
        #modal2 {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            width: 25%;
            height: 30%;
            font-size: 25px;
            transform: translate(-50%, -50%);
            background-color:lightblue;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        #menu ul {
            list-style:none;
            margin-left:4%;
            margin-top: 8%;
            padding:0;
            }

            /* items del menu */

       #menu ul li {
            background-color:#2e518b;
            }

            /* enlaces del menu */

       #menu ul a {
            display:block;
            color:#fff;
            text-decoration:none;
            font-weight:400px;
            font-size:15px;
            padding:10px;
            font-family:"HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;
            text-transform:uppercase;
            letter-spacing:1px;
            }

            /* items del menu */

       #menu ul li {
            position:relative;
            float:left;
            margin:0;
            padding:0;
            }

            /* efecto al pasar el ratón por los items del menu */
        #menu ul li:hover {
            background:#5b78a7;
            }
            /* menu desplegable */

        #menu ul ul {
            display:none;
            position:absolute;
            top:80%;
            left:0;
            background:#eee;
            padding:0;
            z-index: 1; /* Ajuste del z-index para que el menú aparezca por encima del menú principal */
            }

            /* items del menu desplegable */

        #menu ul ul li {
            float:none;
            width:300px;
            }

            /* enlaces de los items del menu desplegable */

        #menu ul ul a {
            line-height:120%;
            padding:10px 15px;
            }

            /* items del menu desplegable al pasar el ratón */

        #menu ul li:hover > ul {
            display:block;
            }
        
            #menu ul ul ul {
            display:none;
            position:absolute;
            top:10%;
            left:0;
            background:#eee;
            padding:0;
            margin-left: 50%; 
            z-index: 2; /* Ajuste del z-index para que el menú aparezca por encima del menú principal */
            }

            /* items del menu desplegable */

        #menu ul ul ul li {
            float:none;
            width:400px;
            }

            /* enlaces de los items del menu desplegable */

        #menu ul ul ul a {
            line-height:120%;
            padding:10px 15px;
            }

            /* items del menu desplegable al pasar el ratón */

        #menu ul ul li:hover > ul {
            display:block;
            }
        
        @media (max-width:600px) {
            #menu ul a, #menu ul ul a, #menu ul ul ul a {
    
                font-weight: 400px;
                font-size: 12px; /* Tamaño de letra más pequeño */
            }            
        
          #menu ul ul ul {
            margin-left: 30%; 
            }
         
         #modal,#modal2 {
            width: 80%;
        }
       
        }
</style>
</head>
<body> 
<nav id="menu">
        <ul>
            <li><a href="#">Menú</a>
                <ul>
                    <li><a href="indexconsulta.php">Informe de satisfacción</a></li>
                    <li><a href="#" onclick="abrirModal()">Entrenar Modelo</a></li>
                    <li><a href="#">Administración de Usuario</a>
                        <ul>
                            <li><a href='NuevoUsuario.php'>Alta Usuario</a></li>
                            <li><a href='BajaUsuario.php'>Baja Usuario</a></li>
                            <li><a href='ActivarUsuario.php'>Activar Usuario</a></li>
                            <li><a href='CambioCategoriaUsAd.php'>Cambio de Categoria a Administrador</a></li>
                            <li><a href='CambioCategoriaAdUs.php'>Cambio de Categoria a Usuario</a></li>
                            <li><a href= 'LimpiarPassword.php'>Limpiar Contraseña</a></li>
                        </ul>
                    </li> 
                    <li><a href="CambioPassword.php">Cambio de Contraseña</a></li>
                    <li><a href="#">Estudio de rendimiento de los diversos modelos</a>
                        <ul>
                            <li><a href="explicacion.php">Análisis de las características de funcionamiento del programa de anàlis de sentimientos</a></li>
                            <li><a href= 'CalificacionModelo1.php'>Calificar con Modelo Epoch 1</a></li>
                            <li><a href= 'CalificacionModelo5.php'>Calificar con Modelo Epoch 5</a></li>
                            <li><a href= 'CalificacionModelo10.php'>Calificar con Modelo Epoch 10</a></li>
                        </ul>
                    </li> 
                   

                   
                    <li><a href="CerrarSesion.php">Salir</a></li>
                </ul>
            </li>
        </ul>
    </nav>

<!-- Ventana modal -->
<div id="modal">
    <div style="height:10%; background-color: red;">

    </div>
    <p>Este proceso dura mas de 2 horas</br> ¿Estás seguro de ejecutar el programa?</p>
    <button type="submit" class="boton-modal" onclick="ejecutarPrograma()">Sí, estoy seguro</button>
    <button type="submit" class="boton-modal" onclick="cerrarModal()">Cancelar</button>
</div>
<div id="modal2" style="animation: parpadeo 2s infinite;background-color:yellow;">
    <div style="height:10%; background-color: red;">
    </div>
    <p>Modelo entrenándose</p>
</div>
</body>
<script>
    // Función para abrir la ventana modal
    function abrirModal() {
        document.getElementById('modal').style.display = 'block';
    }

        // Función para abrir la ventana modal de entrenamiento
        function abrirModal2() {
        document.getElementById('modal2').style.display = 'block';

    }

    // Función para cerrar la ventana modal
    function cerrarModal() {
        document.getElementById('modal').style.display = 'none';
    }

    // Función para ejecutar el programa (llama a entrenar.php)
    function ejecutarPrograma() {
        cerrarModal(); // Cierra la ventana modal antes de redirigir
        abrirModal2();
        window.location.href = 'llamadoEntrenamiento.php'; // Redirige a llamadoEntrenamiento.php

    }


</script>
</html>
