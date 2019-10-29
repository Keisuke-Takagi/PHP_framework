<?php
  $url = explode("/", $_SERVER["REQUEST_URI"]);
  var_dump($url);

  $baseurl = "";
  foreach ($url as $num => $val) {
    if($num === 0){
      continue;
    }elseif($num == count($url) - 1){
      $baseurl .= ucfirst($val);
    }else{
      $baseurl .= $val . "\\";
    }
  }
  echo $baseurl;
  $array_url = explode("\\", $baseurl);
  $app_name = $array_url[0];
  $page_name = end($array_url);
  $page_name = mb_strtolower($page_name);
  // echo '<br> ページネーム' . $page_name;
  // Controller,Viewの定義
  $controller =  $baseurl . "controller";
  $view = $baseurl."view";
  $controller_class = explode("\\", $controller);
  // アクション名取得
  $action_name = $controller_class[2];
  $controller_class = end($controller_class);
  $model_url = $array_url[1];
  $model_name = substr($model_url, 0, -1);

  // モデルクラス名の取得
  $model_class = $model_name . "model" ;
  // モデルファイルの呼び出し
  // $controller_name = $array_url[1] . "_controller";

  // echo '<br> これController_name 将来このコントローラ名使う  [' . $controller_name;
  $view_class = explode("\\", $view);
  $view_class = end($view_class);
  // コントローラクラスの定義
  // echo '<br> これControllerクラス';
  // var_dump($controller_class); 
  // echo '<br> これviewクラス';
  // var_dump($view_class);
  // echo '<br> これmodelクラス';
  // echo $model_class;
  // echo '<br> コレaction名';
  // echo $action_name;
  $template = strtolower($baseurl) . "_template.html";
  $template = __DIR__."\\template\\".$template;
  // Model, Controllerファイル呼び出し部分
  // require_once("controllers/" .strtolower($baseurl) ."_controller.php");
  require_once(__DIR__ . "\\controller_require.php");

  $controller_instance = new Makecontrollerinstance();
  // ここで実行

  $controller_instance = $controller_instance->return_instance($controller_class, $baseurl);


// -------------------------------------------controller
  // $controller_instance = new $controller_class();
  // コントローラに置換する
  // $model_instance = new $model_class;
  // echo '<br> model_instance';
  // var_dump($model_instance);
  // コントローラ処理
  // Postされてきているか確認
// コントローラに置換する
  // if(isset($_POST['email']) || isset($_POST['title'])){
      // セッターゲッターを使ってエラー表示に変換
      // $a = $model_instance->post_setter($_POST['email'],$_POST['password']);
      // $post_checked = $model_instance->post_getter();
    // }


    // if($post_auth_result ==){
    // // postの確認成功時
    // $actionexec = $controller_instance->$action_name();
    // $model_result = $model_instance->$action_name($actionexec);
    // echo '<br>モデルの返り値' . $model_result;
    // }else{
    //   // postの確認失敗時
    //   echo "<br> これaction exec";
    //   $actionexec = "";
    //   var_dump($actionexec);
    //   var_dump($post_auth_result);
    //   echo "emaiiは" . $post_auth_result;
    // }
    // echo $model_url;
    // $actionexec = $controller_instance->$action_name($model_url, $action_name, $page_name, $template);
    // echo "<br> これaction exec";
    // var_dump($actionexec);

    // Controllerで行う
    // if(method_exists($model_instance, "{$action_name}")){
    //   $model_result = $model_instance->$action_name($actionexec);
    // }
    // echo '<br>モデルの返り値' . $model_result;
    // controller実行部分
    $model_results = $controller_instance->$action_name($model_url, $action_name, $page_name, $template,   $model_class );

    $view_path = (__DIR__."/views/bookapp/" . $model_url . "/" . $action_name . "/" . $page_name . "_view.php");
    $template_path = (__DIR__."/template/bookapp/" . $model_url . "/" . $action_name . "/" . $page_name . "_template.html");
    require_once($view_path);
    $view_class = ucfirst($page_name) . "view";
    $view = new $view_class;
    $view->php_print($template_path, $model_results);



    // if(method_exists($controller_instance, "search")){
    //   $action_search = $controller_instance->search();
    // }

    // if(method_exists($model_instance, "login_confirm")){
    //   $login_confirm = $model_instance->login_confirm();
    //   }
  // require_once("views/" .strtolower($baseurl) ."_view.php");



  // 配列に入れていく処理footerDataまでをコントローラーでやる
  // $headerData = $controller_instance->exec();

  // if(method_exists($controller_instance,'content_print')){
  //   $content_array = $controller_instance->content_print();
  // }

  // if(method_exists($controller_instance,'second_content_print')){
  //   $second_content_array = $controller_instance->second_content_print();
  // }

  // $footerData = $controller_instance->footer_print();

// -----------------------view

// コントローラにモデルの条件分岐
// $headerData = $actionexec['headerData'];
// $footerData = $actionexec['footerData'];
// $content_array = $actionexec['content_print'];
echo 'これaction exec とheaderDataの処理';

// var_dump($actionexec);

  //   if(empty($model_result)){
  //     echo "モデル返り値なし";
  //     $v = new $view_class;
  //   }else {
  //     $v = new $view_class($model_result);
  //   }
  //   $v->header_print($template, $headerData);

  //   // Content部分でモデルの返り値が存在するか分岐
  //   if(isset($model_result)){
  //     // モデルに何か返り値がある場合表示するmodel_print関数);
  //     if(isset($post_checked)){
  //     $v->content_model_print($template, $content_array, $model_result);
  //     // POSTに値があるか確認する変数の表示
  //     echo $post_checked;
  //     }
  //     $v->php_print();
  //   }else{
  //     if(isset($content_array)){
  //     // html⇒model⇒phpの記述で表示したい
  //     $v->content_print($template, $content_array);
  //     if(isset($post_checked)){
  //       echo $post_checked;
  //     }
  //     // echo "<br>これbaseviewの返り値   <br>" . $login_confirm;
  //     $v->php_print($actionexec);
  //     }else{
  //       // echo "<br>これbaseviewの返り値   <br>" . $login_confirm;
  //       $v->php_print($actionexec);
  //     }
  //   }
  // if(isset($second_content_array)){
  //   $v->second_content_print($template, $second_content_array);
  // }
  // $v->footer_print($template, $footerData);
?>