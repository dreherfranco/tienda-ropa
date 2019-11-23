<?php
session_start();
require_once 'autoload.php';
require_once 'config/db.php';
require_once 'config/parameters.php';
require_once 'helpers/utils.php';
require_once 'views/layout/header.php';
require_once 'views/layout/sidebar.php';

function show_error(){
	$error = new errorController();
	$error->index();
}
//OBTENER EL NOMBRE DEL CONTROLADOR RECIBIDO POR METODO HTTP GET
if(isset($_GET['controller'])){
	$nombre_controlador = $_GET['controller'].'Controller';

}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
	$nombre_controlador = controller_default;
	
}else{
	show_error();
	exit();
}

if(class_exists($nombre_controlador)){	
	$controlador = new $nombre_controlador();
	
	if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
		$action = $_GET['action'];
		$controlador->$action(); //SE EJECUTA LA ACCION DEL CONTROLADOR ***RECIBIDOS POR METODO GET***
	}elseif(!isset($_GET['controller']) && !isset($_GET['action'])){
		$action_default = action_default;
		$controlador->$action_default();//ACCION POR DEFAULT EN CASO DE QUE NO EXISTA EL CONTROLADOR Y LA ACCION EN METODO GET
	}else{
		show_error();//VISUALIZAR ERROR
	}
}else{
	show_error();
}

require_once 'views/layout/footer.php';


