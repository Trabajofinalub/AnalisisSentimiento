<!DOCTYPE html>
<html lang="es">
<head>
    <title>Analisis de Satisfacion</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="addsearch-category" content="Cursada de Redes en UB">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="./../jquery-3.7.1.js"></script>
</head>
<style>
body {
    background-image: url('./EstacionDeServiciov.jpg');
    background-size: cover;
    background-repeat: no-repeat;
}
.headings-container{
    background-color:lightblue;
    width: 30% ;
    margin-top: 10%;
    margin-left:10%;
    text-align:center;
    border-radius: 10px;
}

        @keyframes parpadeo {
            0% {
                opacity: 1;
            }
            50% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

.opinion {
   
    width: 50%;
    text-align: center;
    margin-top: 210px;
    margin-left:25%;
    opacity:0.9;
}

.imagen {
 
    display: flex;
    margin-left:38%;
    opacity:0.9;
}

.botones{
    display:inline-flex;
    margin-top:1%;
    width: 10% ;
    margin-left:33%;
}

.mi-boton {
    display: inline-flex;
    background-color: #2980b9;  /*#3498db; /* Color inicial del botón */
    color: white; /* Color del texto del botón */
    padding: 10px 20px; /* Ajusta el relleno del botón según tus necesidades */
    border: none; /* Elimina el borde del botón */
    cursor: pointer;
    margin-left:75%;
    border-radius: 10px;
    text-decoration: none;
}

.mi-boton:hover {
    background-color: #3498db; /* Color cuando el cursor pasa sobre el botón */
}
.estrella-seleccionada {
    border: 3px solid green;
}

</style>  
<body> 
    <div class="header">
        <div class="headings-container" style="animation: parpadeo 2s infinite;background-color:yellow;">
            <h3>Su experiencia nos interesa!!!</h3>
        </div>
        <div class="opinion">
            <textarea style="width:100%; height:100px" placeholder="Ingrese aquí su opinión" id="nuevaOpinion" name="nuevaOpinion" required></textarea>
        </div>
        <div class="imagen">
            <input type="image" src="imagenes/Estrellas1.jpg" alt="Botón de Imagen" class="estrella" data-valor="1" required>
            <input type="image" src="imagenes/Estrellas2.jpg" alt="Botón de Imagen" class="estrella" data-valor="2" required>
            <input type="image" src="imagenes/Estrellas3.jpg" alt="Botón de Imagen" class="estrella" data-valor="3" required>
            <input type="image" src="imagenes/Estrellas4.jpg" alt="Botón de Imagen" class="estrella" data-valor="4"required>
            <input type="image" src="imagenes/Estrellas5.jpg" alt="Botón de Imagen" class="estrella" data-valor="5"required>
        </div>
    <div class="botones">
        <a href="Inicio.php" class="mi-boton">Volver</a>
        <button type="submit" class="mi-boton" id="Boton1">Enviar</button>
    </div>
<script>

        document.addEventListener("DOMContentLoaded", function() {  
  
            var nuevaOpinion, calificacion, calificacionModelo;
            
            function obtenerFechaSistema() {
                var fecha = new Date();
                var year = fecha.getFullYear();
                var month = ('0' + (fecha.getMonth() + 1)).slice(-2);
                var day = ('0' + fecha.getDate()).slice(-2);

                return year + '-' + month + '-' + day;
            }

    
            function calificar() {
                var nuevaOpinion = document.getElementById('nuevaOpinion').value;

                // Crear objeto JSON con la opinión
                var data = { "review_text": nuevaOpinion };
                console.log(data);
                $.ajax({
                        type: "POST",
                        url: "./llamadoCalificacion.php",
                        data: data,
                        dataType: "json", 
                        success: function (respuestaDelServer) {
                            console.log(data);
                            console.log(respuestaDelServer);

                            if (respuestaDelServer.classification) {
                                // Puedes acceder a la clasificación directamente desde la respuesta
                                calificacionModelo = respuestaDelServer.classification;
                                alert("Calificación Modelo: " + calificacionModelo);
                                Alta();
                            } else {
                                $('#output').text('Error al cargar datos en la base de datos.');
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error en la llamada AJAX:', xhr.responseText);
                            $('#output').text('Error de comunicación con el servidor.');
                        }
                    });

            }


        function Alta() {
            nuevaOpinion = $("#nuevaOpinion").val();
            calificacion = $(".estrella-seleccionada").data("valor") || "0";
                
                
            // Verifica la longitud del texto
                if (nuevaOpinion.length <= 500) {
                    var fechaOpinion = obtenerFechaSistema();
            
                var filtros = {
                    
                            nuevaOpinion: nuevaOpinion,
                            calificacion: calificacion,
                            calificacionModelo: calificacionModelo,
                            fechaOpinion: fechaOpinion,
                        };
                        console.log(filtros);
                    if (nuevaOpinion && calificacion && fechaOpinion && calificacionModelo) {
              
                        $.ajax({
                            type: "GET",
                            url: "./AltaOpinion.php",
                            data: { datos: JSON.stringify(filtros) },
                            contentType: "application/json; charset=utf-8", // Establece el tipo de contenido
                            success: function (respuestaDelServer) {
                                console.log(filtros);
                                console.log(respuestaDelServer);
                                if (respuestaDelServer === "success") {
                                      $('#output').text('Datos cargados con éxito.');
                                        
                                } else {
                                    $('#output').text('Error al cargar datos en la base de datos.');
                                }
                                
                                        setTimeout(function () {
                                            window.location.href = "./Inicio.php";
                                        }, 2000);
                            },
                            error: function () {
                                $('#output').text('Error al cargar datos.');
                            }
                        });
                    } else {
                        alert("Por favor, complete la opinión y seleccione una estrella");
                    }
                } else {
                    alert("La opinión no debe exceder los 500 caracteres.");
                }
            }          

        $(document).ready(function () {
            $(".estrella").click(function () {
                $(".estrella").removeClass("estrella-seleccionada");
                $(this).addClass("estrella-seleccionada");
            });

            $("#Boton1").click(function () {
                    calificar();
                });
            });
        });
        </script>
    </body>
</html>
