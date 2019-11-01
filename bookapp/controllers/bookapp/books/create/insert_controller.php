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
        $a = $model_instance->post_setter($_POST['title'], $_SESSION['EMAIL']);
        $post_checked = $model_instance->post_getter();
      }
        $count = 0;

        // ここから
          // アクションに対応するモデルメソッドが存在するか確認し、あればモデルアクションの実行
          $model_method_exec = $this->model_method_exist($model_class, $action_name);
          // この下はmodel_method関数内で
          if(!empty($model_method_exec)){
            // modelアクションが存在するとき
            $model_result = $this->model_exec($model_class, $action_name);
            if($model_result == 1){
              header('Location: http://localhost/bookapp/users/index/registration');
            }elseif($model_result == 2){
              header('Location: http://localhost/bookapp/books/new/registration');
            }
            if($model_result == "true" || $model_result == NULL){
              // ここのtrueは   「Modelのバリデーションに成功したという意味」
              header('Location: http://localhost/bookapp/books/index/mainpage');
              require_once(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\views\\database.php");
              echo "<br>" . dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\views\\database.php";
              // コントローラ処理部分
              $database = new Database();
              $dbh = $database->open();
              $title = $_POST['title'];
              $description = $_POST['description'];
              session_start();
              $stmt = $dbh->prepare('select * from users where email = ?');
              $stmt->execute([$_SESSION['EMAIL']]);
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              // var_dump($row);
              $user_id = $row['id'];
              $_SESSION['USER_ID'] = $user_id;
              $_SESSION['EMAIL'] = $_SESSION['EMAIL'];
              // ここから登録
              $stmt = $dbh->prepare('INSERT INTO `books`(`title`, `description`, `user_id`) 
              VALUES (:title, :description, :user_id)');
              $array = array(':title' => $title, 'description' => $description, 'user_id' => $user_id);
              $stmt->execute($array);
            // -----------------view
              // $view_class = $this->view_require($table_name, $action_name, $page_name);
              // $v = new $view_class;
              // $array = $this->array_conversion($controller_name);
              // // var_dump($array);

              // // diplay_printでバリデーション成功時のViewhtmlを作成
              // $display_data = $v->display_print($template, $array);
              // return $display_data;
              }else{
                // Modelのバリデーションに失敗  「modelからエラーが来ているときはこっち」
                
                $view_class = $this->view_require($table_name, $action_name, $page_name);
                $v = new $view_class;
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

?>