<?php
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");

class Destroycontroller  extends Applicationcontroller{
  public function content_print(){
    $content = "  <title>登録本一覧</title>
                  </head>
                  <body>
                  <header id='header'>
                      <div class='app-icons'>
                        <nav class='navbar navbar-default'>
                          <div class='container-fluid'>
                            <div class='navbar-header'>
                              <a class='navbar-brand' href='/bookapp/users/index/registration'>READ-BOOK-RECORDER</a>
                              <div class='login-icon'>
                                <i class='fa fa-user' id='user-login-icon'  aria-hidden='true'></i>
                                <a href='../../../bookapp/users/logout/logout'>ログアウト</a>
                              </div>
                            </div>
                          </div>
                        </nav>
                      </div>
                    </header>
                  <body>
                    <div class='contents_main'>
                      <h1 class='my-3 ml-3'>削除ページ</h1>";
    return[
      "content" => "{$content}"
    ];
  }

  public function delete($table_name, $action_name, $page_name, $template){
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
            if($model_result == 1){
              header('Location: http://localhost/bookapp/books/index/mainpage');
            }
            if($model_result == 2){
              header('Location: http://localhost/bookapp/users/index/registration');
            }
            if($model_result == "true" || $model_result == NULL){
              // ここのtrueは   「Modelのバリデーションに成功したという意味」
              header('Location: http://localhost/bookapp/books/index/mainpage');              
              $database = new Database();
              $dbh = $database->open();
              $stmt = $dbh->prepare('select * from books where id = ?');
              $stmt->execute([$_POST[$_SESSION['COUNT']]]);
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              $stmt2 = $dbh->prepare('delete from books where id = ?');
              $stmt2->execute([$row['id']]);        
              // -----------------view
              $view_class = $this->view_require($table_name, $action_name, $page_name);
              $v = new $view_class;
              $php_view_print = $v->php_print();
              $array = $this->array_conversion($controller_name);
              // diplay_printでバリデーション成功時のViewhtmlを作成
              $display_data = $v->display_print($template, $array, $php_view_print);
              return $display_data;
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