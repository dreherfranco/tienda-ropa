<?php

function controllers_autoload($classname){
	include 'controllers/' . ucfirst($classname) . '.php';
}

spl_autoload_register('controllers_autoload');