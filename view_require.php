<?php
class Makeviewinstance{
  public function return_instance($view_class, $view_path){
    require_once($view_path);
    $v = new $view_class;
    return $v;
  }
}
?>