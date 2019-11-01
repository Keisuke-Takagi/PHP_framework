<?php
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");

class Insertcontroller  extends Applicationcontroller{

  public function create($table_name, $action_name, $page_name, $template){
    $controller_name = get_class();
    echo $controller_name;
    if (!isset($_SESSION)) {
      session_start();
      }
      // ------------------------------------------------------------モデルコントローラー
      $model_class = $this->model_require($table_name, $action_name, $page_name);
      // モデルインスタンス作成

      $model_instance = new $model_class;

      if(isset($_POST['email']) || isset($_POST['title'])){
        // セッターゲッターを使ってエラー表示に変換
        $a = $model_instance->post_setter($_POST['email'],$_POST['password']);
        $post_checked = $model_instance->post_getter();
      }
        $count = 0;
        require_once(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\views\\database.php");
        echo "<br>" . dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\views\\database.php";
        $database = new Database();
        $dbh = $database->open();
        // ここから
          // アクションに対応するモデルメソッドが存在するか確認し、あればモデルアクションの実行
          $model_method_exec = $this->model_method_exist($model_class, $action_name);
          // この下はmodel_method関数内で
          if(!empty($model_method_exec)){
            // modelアクションが存在するとき
            $model_result = $this->model_exec($model_class, $action_name);
            if($model_result == "true" || !isset($model_result)){
              // ここのtrueは   「Modelのバリデーションに成功したという意味」


            // -----------------view
              $v = $this->view_require($table_name, $action_name, $page_name); 
              $array = $this->array_conversion($controller_name);
              // var_dump($array);

              // diplay_printでバリデーション成功時のViewhtmlを作成
              $display_data = $v->display_print($template, $array);
              return $display_data;
              }else{
                // Modelのバリデーションに失敗  「modelからエラーが来ているときはこっち」
                
                $v = $this->view_require($table_name, $action_name, $page_name);
                $array = $this->array_conversion($controller_name);
                // error_printでバリデーション失敗時のhtmlの作成
                $display_data = $v->error_print($template, $array, $view_class,$model_result);
                return $display_data;
              }
            }else{
              $controller_result = '<br><h3>modelのアクションが定義されていません</h3>';
              return $controller_result;
            }
            exit;
          }
        
}