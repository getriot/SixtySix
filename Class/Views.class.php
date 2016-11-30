<?php

namespace Sixtysix\Core;

class Views{
	private static $path;

	/**
	 * [__construct description]
	 */
	function __construct(){
		static::$path = $_SERVER['DOCUMENT_ROOT'].'/Views/';
	}

	/**
	 * [render description]
	 * @param  [type] $view_name [description]
	 * @param  [type] $params    [description]
	 * @return [type]            [description]
	 */
	public function render($view_name, $params=[]){
		$view_location = static::$path . $view_name.'.ptf';
		if(file_exists($view_location)){
			include $view_location;
		}else{
			throw new Error('The view doesn\'t exist');
		}
	}
}

?>