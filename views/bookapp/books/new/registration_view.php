<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");

class Registrationview extends Baseview{
  public function php_print($template, $model_results){
    $htmlStr = file_get_contents($model_results["template_path"]);
    $layout_path = (dirname(dirname(dirname(dirname(__DIR__))))."/template/bookapp/layout/index.html");
    $layout = file_get_contents($layout_path);
    // $model_array = $viewModel->getAll();
    $viewModel = $model_results["model_instance"];
    foreach ($viewModel->getAll() as $k => $v) {
      $htmlStr = str_replace("<<".$k.">>", $v, $htmlStr);
    }
    $htmlStr = str_replace("<<contents>>", $htmlStr, $layout);
    print $htmlStr;
  }
}
?>
