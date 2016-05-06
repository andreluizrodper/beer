<?php
class Router{
	public function __construct(){
		try{
			$content = $this -> findMatchRoute($_GET["route"]);
			if(!$content)
				throw new Exception("Route not found", 1);
			return $content;
		}catch($e){
			return $e -> message;
		}
	}
	private function findMatchRoute($route){
		$files = opendir("controller");
		foreach($files as $file){
			if(is_file("controller/$file")){
				$content = file_get_contents("controller/$file");
				preg_match_all("//", $route, $match);
				if(count($match)){
					include "controller/$file";
					$class = str_replace(".php", "", $file);
					$controller = new $class();
					$params = explode("/", $route);
					return $class -> $match();
					break;
				}
			}
		}
		return false;
	}
}