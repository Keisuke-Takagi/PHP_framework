<?php
// namespace Bookapp\books\new_form;
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");
class Updatecontroller extends  Applicationcontroller {
  public function content_print(){
    $content = '  <title>登録更新ページ</title>
    </head>
    <body>
      <header id="header">
        <div class="app-icons">
          <nav class="navbar navbar-default">
            <div class="container-fluid">
              <div class="navbar-header">
                <a class="navbar-brand" href="registration.php">READ-BOOK-RECORDER</a>
                <div class="login-icon">
                  <i class="fa fa-user" id="user-login-icon"  aria-hidden="true"></i>
                  <a href="../../../bookapp/users/session/logout">ログアウト</a>
                  <a href="../../../bookapp/books/index/mainpage">メインページへ</a>
                </div>
              </div>
            </div>
          </nav>
        </div>
        <title>編集機能ページ</title>
      </header>
      <div class="main">
        <h1>編集機能ページ</h1>';
        return [
          "content" => "{$content}"
        ];
  }
  public function update($table_name, $action_name, $page_name, $template){
    if (!isset($_SESSION)) {
      session_start();
      };
    if(!isset($_SESSION['EMAIL'])){
      header('Location: http://localhost/bookapp/users/index/registration');
      return "";
    };
    $controller_name = get_class();
    echo $controller_name;

      require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\database.php");
      // ------------------------------------------------------------モデル
      $model_class = $this->model_require($table_name, $action_name, $page_name);
      $model_instance = new $model_class;

      // if(isset($_POST['email']) || isset($_POST['title'])){
      //   // セッターゲッターを使ってエラー表示に変換
      //   $a = $model_instance->post_setter($_POST['email'],$_POST['password']);
      //   $post_checked = $model_instance->post_getter();
      // }
          // アクションに対応するモデルメソッドが存在するか確認
          $model_method_exec = $this->model_method_exist($model_class, $action_name);
          if(!empty($model_method_exec)){
            // modelアクションが存在するとき
            $model_result = $this->model_exec($model_class, $action_name);
            if($model_result == "true" || !isset($model_result)){
              header('Location: http://localhost/bookapp/books/index/mainpage');
              $database = new Database();
              $dbh = $database->open();
              $stmt = $dbh->prepare('UPDATE books SET  title = :title, description = :description WHERE id = :id');
              $stmt->bindValue(':id', $_SESSION['BOOK_ID'], PDO::PARAM_INT);
              $stmt->bindValue(':title',$_POST['title'], PDO::PARAM_STR);
              $stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
              $stmt->execute();
            // -----------------view
              $view_class = $this->view_require($table_name, $action_name, $page_name);
              $v = new $view_class;
              $array = $this->array_conversion($controller_name);
              // var_dump($array);
              $display_data = $v->display_print($template, $array,$view_class);
              return $display_data;
              }else{
                // Modelのバリデーションに失敗  「modelからエラーが来ているときはこっち」
                $view_class = $this->view_require($table_name, $action_name, $page_name);
                $v = new $view_class;
                $array = $this->array_conversion($controller_name);
                $display_data = $v->error_print($template, $array, $view_class,$model_result);
                return $display_data;
              }
          }else{
            $controller_result = '<br><h3>modelのアクションが定義されていません</h3>';
            return $controller_result;
          }
        }
}

?>