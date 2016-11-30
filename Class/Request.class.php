<?php

namespace Sixtysix\Core;

class Request{

	/**
	 * [__construct description]
	 */
	function __construct(){
		$this->path = self::get_path();
		$this->params = self::get_params();
		$this->method = self::get_method();
		$this->files = array();
		if($this->method == 'POST' && count($_FILES > 0)){
			foreach($_FILES as $file_info){

				$file = (object)[];

				$file->location = $file_info["tmp_name"];
				$file->name = $file_info["name"];

				array_push($this->files, $file);
			}
		}
	}

	/**
	 * [get_path description]
	 * @return [type] [description]
	 */
	public function get_path(){
		//route always defined as $_GET from apache mod_rewrite
		return $_GET['route'];
	}

	/**
	 * [get_method description]
	 * @return [type] [description]
	 */
	private static function get_method(){
		if(strlen($_GET["params"]) > 0){
			return 'GET';
		}else{
			return 'POST';
		}
	}

	/**
	 * [get_params description]
	 * @return [type] [description]
	 */
	private static function get_params(){
		if($_REQUEST['params']){
			$params = explode('/:', substr($_REQUEST['params'], 1));
			return $params;
		}
		return false;
	}
}
?>