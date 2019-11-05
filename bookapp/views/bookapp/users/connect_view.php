<?php
class Baseview {
  public function print_html($template, $model_results){
    $htmlStr = file_get_contents($model_results["template_path"]);
    $layout_path = (dirname(dirname(dirname(dirname(__DIR__))))."/template/bookapp/layout/index.html");
    $layout = file_get_contents($layout_path);
    $viewModel = $model_results["model_instance"];
    foreach ($viewModel->getAll() as $k => $v) {
      $htmlStr = str_replace("<<".$k.">>", $v, $htmlStr);
    }
    $htmlStr = str_replace("<<contents>>", $htmlStr, $layout);
    print $htmlStr;
  }
}

?>