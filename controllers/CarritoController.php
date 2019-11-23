<?php
require_once 'models/producto.php';

class carritoController{
	
	public function index(){
		if(isset($_SESSION['carrito']) && count($_SESSION['carrito']) >= 1){
			$carrito = $_SESSION['carrito'];
		}else{
			$carrito = array(); 
		}
		require_once 'views/carrito/index.php';
	}
	
	public function add(){
		if(isset($_GET['id'])){
			$producto_id = $_GET['id'];
		}else{
			header('Location:'.base_url);
		}
		//SI EXISTE EL PRODUCTO YA ESTA EN EL CARRITO SE LE SUMA UNA UNIDAD
		if(isset($_SESSION['carrito'])){
			$counter = 0;
			foreach($_SESSION['carrito'] as $indice => $elemento){
				if($elemento['id_producto'] == $producto_id){
					$_SESSION['carrito'][$indice]['unidades']++;
					$counter++;
				}
			}	
		}
		//SI EL PRODUCTO NO ESTA EN EL CARRITO 
		if(!isset($counter) || $counter == 0){
			// Conseguir producto
			$producto = new Producto();
			$producto->setId($producto_id);
			$producto = $producto->getOne(); //OBTENER EL PRODUCTO DE LA BASE DE DATOS ***ver getOne en ProductoController***

			// Añadir al carrito 
			if(is_object($producto)){
				$_SESSION['carrito'][] = array(
					"id_producto" => $producto->id,
					"precio" => $producto->precio,
					"unidades" => 1,
					"producto" => $producto
				);
			}
		}
		
		header("Location:".base_url."carrito/index");
	}
	
	public function delete(){
                //ELIMINAR UN PRODUCTO DEL CARRITO
		if(isset($_GET['index'])){
			$index = $_GET['index'];
			unset($_SESSION['carrito'][$index]);
		}
		header("Location:".base_url."carrito/index");
	}
	
	public function up(){
                //SUMARLE UNA UNIDAD A UN PRODUCTO EN ESPECIFICO AL CARRITO
		if(isset($_GET['index'])){
			$index = $_GET['index'];
			$_SESSION['carrito'][$index]['unidades']++;
		}
		header("Location:".base_url."carrito/index");
	}
	
	public function down(){
                //QUITARLE UNA UNIDAD A UNO DE LOS PRODUCTOS DEL CARRITO
		if(isset($_GET['index'])){
			$index = $_GET['index'];
			$_SESSION['carrito'][$index]['unidades']--;
			//SI LAS UNIDADES SON 0 SE BORRARA EL PRODUCTO DEL CARRITO
			if($_SESSION['carrito'][$index]['unidades'] == 0){
				unset($_SESSION['carrito'][$index]);
			}
		}
		header("Location:".base_url."carrito/index");
	}
	
	public function delete_all(){
                //QUITAR TODO DEL CARRITO
		unset($_SESSION['carrito']);
		header("Location:".base_url."carrito/index");
	}
	
}