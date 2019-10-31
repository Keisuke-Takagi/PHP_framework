<?php
  $url = explode("/", $_SERVER["REQUEST_URI"]);

  $baseurl = "";
  foreach ($url as $num => $val) {
    if($num === 0){
      continue;
    }elseif($num == count($url) - 1){
      $baseurl .= ucfirst($val);
    }else{
      $baseurl .= $val . "/";
    }
  }
  echo $baseurl;
  $array_url = explode("/", $baseurl);
  $app_name = $array_url[0];
  $page_name = end($array_url);
  $page_name = mb_strtolower($page_name);
  // echo '<br> ページネーム' . $page_name;
  // Controller,Viewの定義
  $controller =  $baseurl . "controller";
  $view = $baseurl."view";
  $controller_class = explode("/", $controller);
  // アクション名取得
  $action_name = $controller_class[2];
  $controller_class = end($controller_class);
  $model_url = $array_url[1];

  // echo '<br> これController_name 将来このコントローラ名使う  [' . $controller_name;
  $view_class = explode("\\", $view);
  $view_class = end($view_class);
  // コントローラクラスの定義

  $template = strtolower($baseurl) . "_template.html";
  $template = __DIR__."/template/".$template;
  // Model, Controllerファイル呼び出し部分
  // require_once("controllers/" .strtolower($baseurl) ."_controller.php");
  require_once(__DIR__ . "\\controller_require.php");

  $controller_instance = new Makecontrollerinstance();
  // ここで実行

  $controller_instance = $controller_instance->return_instance($controller_class, $baseurl);


    $model_results = $controller_instance->$action_name($model_url, $action_name, $page_name, $template);

    $view_path = (__DIR__."/views/bookapp/" . $model_url . "/" . $action_name . "/" . $page_name . "_view.php");
    $template_path = (__DIR__."/template/bookapp/" . $model_url . "/" . $action_name . "/" . $page_name . "_template.html");
    require_once($view_path);
    $view_class = ucfirst($page_name) . "view";
    $view = new $view_class;
    $view->php_print($template_path, $model_results);
?>