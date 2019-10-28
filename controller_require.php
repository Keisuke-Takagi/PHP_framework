<?php
Class Makecontrollerinstance {
  public function return_instance($controller_class, $baseurl){
    require_once("controllers/" .strtolower($baseurl) ."_controller.php");
    $controller_instance = new $controller_class();
    return $controller_instance;
  }
}
?>