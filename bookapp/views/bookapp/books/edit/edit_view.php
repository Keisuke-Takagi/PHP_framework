<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");

class Editview extends Baseview{
  public function php_print($template, $model_results){
    $this->print_html($template, $model_results);
  }
} 
?>