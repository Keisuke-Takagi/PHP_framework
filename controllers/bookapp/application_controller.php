<?php
class Applicationcontroller {
  public function __construct(){
    if (!isset($_SESSION)) {
      session_start();
      }
  }
  public function exec(){
    $header = "<!DOCTYPE html>
              <html lang='ja'>
              <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                <link rel='stylesheet' href='https://unpkg.com/ress/dist/ress.min.css'>
                <link rel='stylesheet' type='text/css' href='../../views/bookapp/index/style.scss'>
                <link href='https://use.fontawesome.com/releases/v5.6.1/css/all.css' rel='stylesheet'>

                <link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
                <script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
                <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>

                <meta name='viewport' content='width=device-width,initial-scale=1'>
                ";
    return[
      "header" => "{$header}"
    ];
  }
  public function footer_print(){
    $footer = "<footer>
                  <div id='footermenu' class='inner'>
                  <ul>
                    <li class='title'>ホーム</li>
                    <li><a href='contact.html' class='footer-link'>お問い合わせ</a></li>
                    <li><a href='company.html' class='footer-link'>会社概要</a></li>
                  </ul>
                  <ul>
                    <li class='title'>メニュータイトル01</li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                  </ul>
                  <ul>
                    <li class='title'>メニュータイトル02</li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                  </ul>
                  <ul>
                    <li class='title'>メニュータイトル03</li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                  </ul>
                  <ul>
                    <li class='title'>メニュータイトル04</li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                    <li><a href='#' class='footer-link'>メニューサンプル</a></li>
                  </ul>
                </div>
              </footer>
              </body>
              </html>";
    return [
      "footer" => "{$footer}"
    ];
  }
  public function model_require($model_url, $action_name, $page_name){
    $model_name = rtrim($model_url, 's');
    require_once(dirname(dirname(__DIR__)) . "/models/bookapp/" . $model_url. "/" . $model_name . ".php");
    $model_class = ucfirst($model_name) . "model";
    return $model_class;
  }
  public function view_require($model_url, $action_name, $page_name){
    require_once(dirname(dirname(__DIR__)) . '\\view_require.php');
    $view_path = (dirname(dirname(__DIR__)) . "/views/bookapp/" . $model_url . "/" . $action_name . "/" . $page_name . "_view.php");
    $view_class = ucfirst($page_name) . "view";
    $v = new makeviewinstance;
    $v = $v->return_instance($view_class, $view_path);
    var_dump($v);

    
    return $v;
    // return $view_class;
  }

  public function array_conversion($controller_name){
    // この関数が呼べてない
    $controller_instance = new $controller_name();
    $count_content = 0;
    $headerData = $this->exec();
    var_dump($headerData);
    if(method_exists($controller_name,'content_print')){
      $content_array = $controller_instance->content_print();
      $count_content += 1;
    }
  
    if(method_exists($controller_name,'second_content_print')){
      $second_content_array = $controller_instance->second_content_print();
      $count_content += 1;
    }
  
    $footerData = $controller_instance->footer_print();
    if($count_content == 0){
      return [
        "header" => "{$headerData['header']}",
        "footer" => "{$footerData['footer']}"
      ];
    }elseif($count_content == 1){
      return [
        "header" => "{$headerData['header']}",
        "content" => "{$content_array['content']}",
        "footer" => "{$footerData['footer']}"
      ]; 
    }else{
      // var_dump($content_array);
      // var_dump($second_content_array);
      $arr = [
        "header" => "{$headerData['header']}",
        "content" => "{$content_array['content']}",
        "content2" => "{$second_content_array['content2']}",
        "footer" => "{$footerData['footer']}"
      ]; 
      return $arr;
    }
  }
  public function model_method_exist($model_class, $action_name){
    // modelの有無での振り分け処理
    if(method_exists("{$model_class}", "{$action_name}")){
      // $model_instance = new $model_class;
      // $model_exec = $model_instance->$action_name();
      return "true";
    }else{
      return "";
    }
  }
  public function model_exec($model_class, $action_name){
    $model_instance = new $model_class;
    $model_exec = $model_instance->$action_name();
    return $model_exec;
  }
  public function error_model_exec($model_class, $action_name, $e){
    $model_instance = new $model_class;
    $action_name = $action_name. "_erorr";
    $model_exec = $model_instance->$action_name($e);
    return $model_exec;
  }
}
 
?>