<!DOCTYPE HTML>
<html>
<head>
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <title> Deep Agro | Reconocimiento de Maleza en Video </title>
    <meta name="description" content="Reconocimiento de Maleza en Video.">
    <meta name="keywords" content="Reconocimiento de Maleza en Video, deeplearning, machine learning, deep learning, IA, lcc tesina.">
    <link rel="apple-touch-icon" href="images/touch/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/touch/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/touch/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="144x144" href="images/touch/apple-touch-icon-144x144.png">
    <meta property="og:title" content="Deep Agro | Reconocimiento de Maleza en Video">
    <meta property="og:description" content="Deep Agro | Reconocimiento de Maleza en Video">
    <meta property="og:url" content="Deep Agro | Reconocimiento de Maleza en Video">
    <meta property="og:image" content="Deep Agro | Reconocimiento de Maleza en Video">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <!--[if lt IE 9]>
        <script src="js/html5.js"></script>
        <script src="js/respond.js"></script>
    <![endif]-->
    
    <style type="text/css">
        .check
{
    opacity:0.15;
	color:#996;
	
}
img {

		padding:0px;

    }

    .selected {

		border:2px solid red;
		

    }

    </style>
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/FileSaver.js"></script>       



<!-- Esta seccion es para el seguimiento de los usuarios de etiquetados, se debe cambiar para otros proyectos o eliminar -->     
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-36375944-9', 'auto');
  ga('send', 'pageview');

</script>
<!-- Hasta aca-->    



</head>

<body class="no-js">
    <div class="main">
        <header>
            <div class="wrap">
                <img src="upload/iphone.png" height="532" width="352" alt="Deep Agro | Reconocimiento de Maleza en Video" class="header-img">
                <div class="header-wrapper">
                    <h1> Deep Agro <span>Tagger</span></h1>
                    <p>Aplicación web para etiquetado de imágenes. <br>
                    Reconocimiento de malezas en video con técnicas de Deep Learning.</p>
                    <p class="autor"><a href="#">Baruffaldi Juan Manuel</a></p>
                    <div class="buttons-wrapper">
						<a id="clickTag" href="#tagger" class="button">Ir al aplicativo</a>
                        <a href="files/paper.pdf" class="button button-stripe">Leer más</a>
                    </div>
                </div>
                <!-- /.header-wrapper -->
            </div>
            <!-- /.wrap -->
        </header>
                 
            
            <div class="discover clearfix" id="Taggeador" data-section="Taggeador">
                <div class="wrap">
                    <div class="discover-content clearfix">
                        <h2>Etiquetador</h2>
                        <p>En este aplicativo usted deberá seleccionar las imágenes donde aparece lo que se le indique a continuación.<br>
                        No hace falta que seleccione todas las apariciones, solo las que considere y luego presione SIGUIENTE. <br>
		Previo necesitamos que nos de un nombre de referencia y que siempre utilice el mismo nombre durante el etiquetado. <br><br>
		Estamos generando una base de datos etiquetada para aplicar Inteligencia Artificial. <br><br>		
		¡Desde ya muchas gracias!
						</p>
                        
                        
                    </div>
                    <div class="discover-img">
                        <div class="discover-img-inside"><img src="upload/discover.png" height="586" width="400" alt=""></div>
                    </div>
                </div>
                <!-- /.wrap -->
            </div>
            <!-- /.discover clearfix -->
            <div class="video clearfix">
                <div class="wrap">
					
									
<?php
	/* Baruffaldi Juan Manuel, baruffaldi.jm@gmail.com
	 * Este codigo asume que disponemos de una carpeta para cada imagen donde adentro se encutran todos los recortes de la misma.
	 * Se toman cortados para simplificar la web evitando los recortes o selecciones de ROI y tambien porque la red neuronal con
	 * la que se trabajo (red discriminate de DCGAN semi-supervisado) toma parches de 64x64 pixeles de cada imagen.
	 * Se asume que cada carpeta tiene un nombre numerico para facilitar el rastreo.
	 * Dados los tamaños de las imagenes utilizadas se obtenia una cantidad de 23 parches de ancho, pero eso depende del uso de 
	 * esta web con lo cual puede cambiarse en el parametro width_pat. Sirve para la visualizacion en pantalla.
	 * Se pidio el etiquetado de 3 clases y se las diferencio en el html por un color.
	 * Hablamos de frame porque se utilizo sobre videos extrayendo los frames, pero significan imagenes.
	 * Dado nuestro interes de reconocer malezas se priorizo el pedido de etiquetado buscando una probabilidad de aparicion de
	 * 50% para clase 0, 25% para clase 1 y 25% para clase 2. Esto se puede modificar y dejar completamente aleatorio.
	 * Se pide seleccionar (por medio del clickeo) los parches de la imagen donde visualiza lo pedido.
	 * No se limita la cantidad de parches que el usuario puede marcar pero se suguiere 10 por imagen.
	 * Luego se presiona siguiente y se avanza a otra imagen (pude ser de forma aleatoria o consecutiva si se desea) en la misma 
	 * seccion de la web donde se quedo.
	 * Web responsive accesible desde cualquier dispositivo. 
	 */
	//Definiciones de parametros
	$dirimg = "./images"; //carpeta de donde se toman los parches que forman una imagen
	$cant_frames = 2; //Cantidad total de carpetas (sumada la carpeta 0)
	$init_frames = 0; //Numero de frame de inicio (recordar que los nombres de carpetas deben ser numericos y consecutivos)
	$finish_frames = 1; //Numero de frame final
	$width_pat=23;//Cantidad de parches por ancho
	$cant_clases = 3; //cantidad de clases a etiquetar
	$clases = array(
		0 => "<font color=\"#f91403\"> maleza </font>",
		1 => "<font color=\"#2aae10\"> soja </font>",
		2 => "<font color=\"#feac33\"> tierra (o entresurco) </font>",
	);
		
	error_reporting(E_ALL);
	session_start();
	/*session is started if you don't write this line can't use $_Session  global variable*/
		      
	/*session was getting*/
	$aux = rand(0,2); //0 maleza, 1 soja, 2 entresurco. En caso de querer solamente etiquetar maleza y soja (por ejemplo) se debe 
					  // cambiar el aleatorio al rango entre 0 y 1
	
	//Aca le damos prioridad a la clase 0 para pedir taggeo. 
	//Apariciones aleatorias se busca un 50% clase 0, 25% clase 1 y 25% clase 2.
	if ($aux == 0)
		$class = rand(0,($cant_clases-1)); //clase a tagear 
	else
		$class = 0;
	
		
	$name_c = $clases[$class]; //Asignamos el nombre correspondiente
	$imgdir = rand($init_frames,$finish_frames);  //por defecto debería ser al azar
		
	if (isset($_GET['imgdir'])) {  //entra si hay un get de imgdir, si no no
		$imgdir = $_GET['imgdir'];
	}
	
	//calculamos la proxima imagen	
	$img_next = ($imgdir+1-$init_frames)%$cant_frames + $init_frames; //podria ser al azar
		
	$dirname = $dirimg . "/" . $imgdir;
	$dir = opendir($dirname);

	//Leemos todos los archivos dentro de la carpeta de la imagen 
	// Asumimos que solo estan los parches de la imagen y no otros archivos
	while(false != ($file = readdir($dir)))
	{
		if(($file != ".") and ($file != "..") and ($file != "index.php"))
		{
		  $list[] = $file;
		}
	}

	sort($list); //ordenamos
				
			//Generamos el html para la visualizacion		
			echo("<div id=\"tagger\" data-section=\"tagger\" class=\"video-title\">Seleccione <font color=\"#7F0000\">10</font> (o menos) 
			cuadrados de la imagen donde ve $name_c:</div>");
			echo("<div class=\"video-subtitle\">Si no encuentra lo pedido solo pase a la siguiente imagen.</div>");
			
			//echo("</div>");
			//echo("</div>");
			
			echo("<div class=\"container\">");
			echo("<div class=\"row\" align=\"center\">");
				echo("<form  id=\"formulario\" method=\"get\" name=\"fomulario\">"); 		
					
	if (isset($_GET['firstname'])) {  //entra si hay un get de firstname, si no no
		$firstname = $_GET['firstname'];
	}
	
	$sesion_name = $_SESSION["NAME"];
	if ($sesion_name == "") {
		$sesion_name = $firstname;
		$_SESSION["NAME"] = $firstname;
	}
		
	
	echo("<br>");	
	//Si no ingreso el nombre de refencia lo pedimos. Pero con una sola vez que lo ingrese ya alcanza y no lo volvemos a pedir
	//Deben estar habilitadas las variables de session en el servidor php para que esto funcione, si no hay que tipear todo el
	//tiempo el nombre.
		if( ($sesion_name == "") && ($firstname=="") )
		{
			echo("<div class=\"buttons-wrapper\">");
			echo("<h3> <label class=\"video-subtitle\" for=\"firstname\">Indique su nombre: </label> <input class=\"button\" type=\"text\" id=\"firstname\" name=\"firstname\" required><br> </h3>");
			echo("<br></div>");
			$sesion_name = "NONE_1215";
			
		}
		
		echo("<div class=\"form-group\" align=\"center\" style=\"font-size: 0px; line-height: 0px; \" >");
		
	
	//Mostramos en pantalla la union de todos los parches en una sola imagen. Debe verse como la imagen original	
	$cnt=1;
	foreach($list as $item) {
				
		if(($cnt % $width_pat) == 0)
			echo("<img c=$class u=$sesion_name m=$cant_frames id=$img_next src=$dirname/$item class=\"img-thumbnail img-check\" width=\"4%\" height=\"4%\"> <br>");
		else
			echo("<img c=$class u=$sesion_name m=$cant_frames id=$img_next src=$dirname/$item class=\"img-thumbnail img-check\" width=\"4%\" height=\"4%\">");
			
		$cnt++;
		
	}
	

?>				

						</div>	
						
						<div class="row" align="center">	
							<input type="submit" id="enviar" value=" SIGUIENTE " class="button" > 
						</div>							
						
						</form>
					</div>	
				</div>  
				
				
				
				</div>	
				</div>              
                
                
					
					
					
                </div>
                <!-- /.wrap -->
            </div>
            <!-- /.videos clearfix -->
            
            
            <div class="comments clearfix">
                <div class="wrap">
                    <div class="tab">
                        <div class="box visible">
                            <h4>Muchas gracias por su aporte! <a href="#">#DeepAgro</a></h4>
                            <p>Al finalizar la tesis serán publicados los resultados.</p>
                        </div>

                    </div>
                </div>
                <!-- /.wrap -->
            </div>
            
            
        </div>
        <!-- /.spanning-columns -->
    </div>
    <!-- /.main -->
    <footer>
        <div class="wrap">
            <p><strong>Baruffaldi Juan Manuel</strong>, Licenciatura en Ciencias de la Computación.<br>
            Universidad Nacional de Rosario. CIFASIS-CONICET. <br> Mayo 2017</p>
        </div>
        <!-- /.wrap -->
    </footer>

    <script src="js/jquery.js"></script>
    <script src="js/library.js"></script>
    <script src="js/script.js"></script>
    <script src="js/retina.js"></script>
	
</body>
</html>


<script>
  $(function() {
      $('a[href*=#]:not([href=#])').click(function() { //comportamiento de clickeado
          if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                  $('html,body').animate({
                      scrollTop: target.offset().top
                  }, 1000);
                  return false;
              }
          }
      });
  });
</script>


<?php session_start(); $session_value=(isset($_SESSION["NAME"]))?$_SESSION["NAME"]:''; ?>

<script type="text/javascript">
$(document).ready(function(e){
			
			var session = <?php  echo json_encode($session_value); ?>;
			
			if( session.length > 0)
				document.getElementById('clickTag').click();
	
    		$(".img-check").click(function(){
				$(this).toggleClass("check");
			});
			
							
			$('#enviar').click( function(){
				
				var imagenes='\n';
				$(".check").each(function() {
					clase = $(this).attr("c");
					imagenes+=$(this).attr("src")+' '+clase+'\n';//el 0 representa la clase de maleza
					imgdir = $(this).attr("id");
					cant_frames = $(this).attr("m");
					user = $(this).attr("u");
					
					if(user == "NONE_1215")
					{
						var firstname = document.getElementById('firstname');
						user = firstname.value;
					}
					
					
				});	
				//Tomamos los datos de clickeo y los enviamos por post a enviar.php
				var formData = {
					'maleza': imagenes,
					'imgdir': imgdir,
					'cant_frames': cant_frames,
					'user': user 
				};

				
				$.ajax({
					type: "POST",
					url: "enviar.php",
					data: formData, 
					
				}); 
				
				alert("Muchas Gracias por su ayuda");
				
			});
	});	
</script>
