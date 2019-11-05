<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/users/connect_view.php");
// require_once(dirname(dirname(dirname(__FILE__))) . "/index/head.php");
Class Loginview extends Baseview{
  public function php_print($template, $model_results){
    $this->print_html($template, $model_results);
  }
}
?>