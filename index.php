<?php
	require 'Class/Autoloader.class.php';
	use SixtySix\Core\Router as Router;

	$router = new Router();

	//checking wether the request is valid or not
	if($router->is_request_valid()){
		//executin request
		$router->exec_request();
	}else{
		//throw an error
		throw new Error("Wrong method ".$router->request->method." or parameter missing");
	}

?>