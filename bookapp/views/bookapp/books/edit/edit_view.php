<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");



class Editview extends Baseview{
  public function php_print($template, $model_results){
    $htmlStr ="";
    $viewModel = $model_results["model_instance"];
    $temp = $model_results["template_path"];

    $htmlStr = file_get_contents($temp);
    $layout_path = (dirname(dirname(dirname(dirname(__DIR__))))."/template/bookapp/layout/index.html");
    $layout = file_get_contents($layout_path);
    // $model_array = $viewModel->getAll();
    $a = $viewModel->getAll();
    var_dump($a);
    foreach ($viewModel->getAll() as $k => $v) {
      $htmlStr = str_replace("<<".$k.">>", $v, $htmlStr);
    }
    $htmlStr = str_replace("<<contents>>", $htmlStr, $layout);
    print $htmlStr;

  }
  public function php_eroor_print(){
    
  }
} 
?>