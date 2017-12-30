# WebTagger
Web para etiquetar secciones de una imagen utilizada para una red semi-supervisada de DCGAN. 

## Introducción

Sistema de etiquetado web aplicado para la creación de una base de datos sobre malezas en imágenes para la tesina de Juan Manuel Baruffaldi sobre Reconocimiento de malezas en video. 
Se desarrolló en php tomando los parches ya recortados de los frames seleccionados para el entrenamiento y testeo. Si bien esta preparado para seleccionar 3 clases en la imagen (maleza, entre-surco o soja), puede modificarse fácilmente. Se usó métodos get y post para envio de datos, javascript para el comportamiento de clickeo, variables de sesión y formato .csv para el almacenamiento del etiquetado. No se provee registro de usuarios ni inicio de sesión, como así tampoco ninguna medida de seguridad para el sistema.
El template web fue descargado de forma gratuita y se desarrolló sobre el mismo la lógica en php. Se incorporó google analytics que debería modificarse para otros proyectos.

## Instalación

Descargar los archivos fuentes:

~$ git clone git@github.com:juanmab37/webtagger.git 

Subirlo a cualquier servidor php. Cambiar los permisos para poder almacenar archivos (en caso de ser necesario ya que algunos servidores te lo permiten por defecto)

~$  sudo chmod 777 -R webtagger

## Modo de uso

Dentro de la carpeta disponemos de la siguiente estructura:
- files: Archivos extras como por ejemplo papers.
- images: Carpeta que contiene subcarpetas por cada frame a etiquetar.
- js: Funcionalidad de javascript
- index.php: Contiene desde el código html hasta la lógica de etiquetado.
- enviar.php: Realiza el almacenamiento de los datos en archivo .csv
- Otros archivos: Se disponen archivos de diseño, fuentes, etc; como así también algunos scripts de linux que se usaron para automatizar algunas tareas.

Para re-utilizar esta web con el fin de etiquetar otras cosas se debe modificar el archivo index.php (leer los comentarios del código para interpretar los parámetros) y las imágenes de la carpeta images.

