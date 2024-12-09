<!DOCTYPE html>
<html lang="es">
<head>
    <title>Analisis de Satisfacion</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="addsearch-category" content="Cursada de Redes en UB">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="./jquery-3.7.1.js"></script>
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

@media only screen and (max-width: 600px) {
.imagen {

    margin-left:10%;
    
}
.opinion {
   
    width: 70%;
    text-align: center;
    margin-top: 310px;
    margin-left:15%;

} 
   .mi-boton {

    margin-left:15%;

} 
    }

/* Estilo para la ventana emergente */
#calificandoModal {
    display: none;
    position: fixed;
    top: 10%;
    left: 15%;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

#calificandoModal div {
    position: relative;
    padding: 10px;
    background-color: blue; /* Fondo azul */
    color: white; /* Texto blanco */
    text-align: center;
    border-radius: 10px;
    width: 30%;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
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
        br
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

       <!-- Ventana emergente "Calificando..." -->
       <div id="calificandoModal">
        <div>
            <h2>Calificando...</h2>
        </div>
    </div>

<script>

        document.addEventListener("DOMContentLoaded", function() {  
            var nuevaOpinion, calificacion, calificacionModelo;

           
            function mostrarVentanaCalificando() {
                $("#calificandoModal").show();
            }

            function ocultarVentanaCalificando() {
                $("#calificandoModal").hide();
            }
            
            function obtenerFechaSistema() {
                var fecha = new Date();
                var year = fecha.getFullYear();
                var month = ('0' + (fecha.getMonth() + 1)).slice(-2);
                var day = ('0' + fecha.getDate()).slice(-2);

                return year + '-' + month + '-' + day;
            }

            function validarCampos() {
                nuevaOpinion = document.getElementById('nuevaOpinion').value;
                calificacion = $(".estrella-seleccionada").data("valor") || 0;

                // Verificar si se ingresó una opinión
                if (!nuevaOpinion) {
                    alert("Por favor, ingrese su opinión.");
                    return false;
                }

                // Verificar si se seleccionó una estrella
                if (calificacion === 0) {
                    alert("Por favor, seleccione una calificación.");
                    return false;
                }

                return true;
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
                            calificacionModelo = respuestaDelServer.classification;
                            alert("Calificación Modelo: " + calificacionModelo);
                            Alta();
                            ocultarVentanaCalificando();
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
                calificacion = $(".estrella-seleccionada").data("valor");

                if (nuevaOpinion.length <= 500) {
                    var fechaOpinion = obtenerFechaSistema();

                    var filtros = {
                        nuevaOpinion: nuevaOpinion,
                        calificacion: calificacion,
                        calificacionModelo: calificacionModelo,
                        fechaOpinion: fechaOpinion,
                    };
                    console.log(filtros);

                    $.ajax({
                        type: "GET",
                        url: "./AltaOpinion.php",
                        data: { datos: JSON.stringify(filtros) },
                        contentType: "application/json; charset=utf-8",
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
                    alert("La opinión no debe exceder los 500 caracteres.");
                }
            }

            $(document).ready(function () {
                $(".estrella").click(function () {
                    $(".estrella").removeClass("estrella-seleccionada");
                    $(this).addClass("estrella-seleccionada");
                });

                $("#Boton1").click(function (event) {
                    event.preventDefault();

                    if (validarCampos()) {
                        mostrarVentanaCalificando();  // Mostrar ventana "Calificando..."
                        calificar();
                    }
                });
            });
        });
</script>
</body>
</html>
