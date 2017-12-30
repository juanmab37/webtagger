

<?php
 
	if($_POST['maleza'] ==""){
		echo "Debes completar todos los datos (maleza)";
		return 0;
	}
	
	if($_POST['imgdir'] ==""){
		echo "Debes completar todos los datos (imgdir)";
		return 0;
	}
	
	if($_POST['cant_frames'] ==""){
		echo "Debes completar todos los datos (frames)";
		return 0;
	}
	
	
	error_reporting(E_ALL);
	session_start();
	
	if($_SESSION["NAME"] == "")
		$_SESSION["NAME"] = $_POST['user'];
		
	$val = array ($_POST['maleza'],$_SESSION["NAME"]);	
	
	
	$cant_frames = $_POST['cant_frames']; //hacerlo automatico
	
	if($_POST['imgdir']=='0')
		$id = $cant_frames -1;
	else
		$id = $_POST['imgdir'] - 1;
		
	$name = 'file_' . $id . '_';
	$name_save = uniqid($name) . '.csv'; //genera nombres unicos sin repetir de 13 caracteres. Para tener 23 caracteres usar uniqid('file',true)
	$fp = fopen($name_save, 'w'); //verificar porque no lo crea
	fputcsv($fp, $val);
	
	fclose($fp);

?>


