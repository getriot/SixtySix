<?php

namespace SixtySix\Core;

class Router{
	private static $config;
	private static $routes;

	/**
	 * [__construct description]
	 */
	function __construct(){
		static::$config = self::get_instance();
		$this->request = new Request();
		$this->view = new Views();
		// var_dump($_SERVER); -->TODO
	}

	/**
	 * [get_instance description]
	 * @return [type] [description]
	 */
	public static function get_instance(){
		if(empty(static::$config)){
			static::$config = json_decode(file_get_contents('config.json'));
			if(is_null(static::$config)){
				throw new Error("no config found");
			}
			self::parse_config();
		}else{
			return new self();
		}
		return static::$config;
	}

	/**
	 * [parse_config description]
	 * @return [type] [description]
	 */
	public static function parse_config(){
		$i = 0;
		foreach(static::$config as $route){
			/**
			 * Defining route index as:
			 * $route["location-path"] = n;
			 * properties at:
			 * $config[static::$routes[$route->location]]
			 */
			$location = explode(':', $route->location);
			static::$routes[$location[0]] = $i;
			$i++;
		}
		//var_dump(static::$routes);
	}

	/**
	 * [is_request_valid description]
	 * @return boolean [description]
	 */
	public function is_request_valid(){
		$this->path_properties = static::$config[static::$routes[$this->request->path]];
		preg_match_all('/:([a-zA-Z0-9]+)/', $this->path_properties->location, $this->config_params);
		$this->config_params = $this->config_params[1];
		if($this->path_properties->method == $this->request->method){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * [associate_params description]
	 * @return [type] [description]
	 */
	private function associate_params(){
		$controller_args = array();
		$i = 0;
		foreach($this->config_params as $param_name){
			if(isset($this->request->params[$i])){
				$controller_args[$i] = $this->request->params[$i];
			}
			$i++;
		}
		return $controller_args;
	}

	public function exec_request(){
		$params = $this->associate_params();
		if(is_callable($this->path_properties->controller) && count($params)>0){
			$view_params = forward_static_call_array($this->path_properties->controller, $params);//[array]
			$this->view->render($this->path_properties->view, $view_params);
		}else{
			$this->view->render($this->path_properties->view);
		}
	}

}

?>