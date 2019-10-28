<?php
// namespace Bookapp\books\new_form;
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");


class Registrationcontroller extends Applicationcontroller{
  public function content_print(){
    $content = "<title>読んだ本を登録する</title>
                </head>
                <body>
                <header id='header'>
                    <div class='app-icons'>
                      <nav class='navbar navbar-default'>
                        <div class='container-fluid'>
                          <div class='navbar-header'>
                            <a class='navbar-brand' href='registration.php'>READ-BOOK-RECORDER</a>
                            <div class='login-icon'>
                              <i class='fa fa-user' id='user-login-icon'  aria-hidden='true'></i>
                              <a href='../../../bookapp/users/logout/logout'>ログアウト</a>
                            </div>
                          </div>
                        </div>
                      </nav>
                    </div>
                  </header>
                  <p>
                  </p>
                <body>
                    <div class='ontents_main'>
                    <h1> 読んだ本登録フォーム</h1>
                    <form action='http://localhost/bookapp/books/create/insert' method='post' class='new-user-form'>
                      <td>
                        <tr>
                          <p>本のタイトル</p>
                          <input type='text' name='title' class='form-input'>
                        </tr>
                        <tr>
                          <p>感想・要約</p>
                          <textarea name='description' cols='20' rows='10' class='form_book_description'></textarea>
                        </tr>
                      </td>
                      <button type='submit' class='btn btn-success btn-lg'>本の登録</button>
                    </form>
                    </div>
                </body>";
      return [
        "content" => "{$content}"
      ];
  }
  public function new($table_name, $action_name, $page_name, $template){
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
          $model_method_exec = $this->model_method_exist($model_class, $action_name);
          // この下はmodel_method関数内で
          if(!empty($model_method_exec)){
            // modelアクションが存在するとき
            $model_result = $this->model_exec($model_class, $action_name);
            echo 'model_result<br>' . $model_result;
            if($model_result == "true" || !isset($model_result)){
              // ここのtrueは   「Modelのバリデーションに成功したという意味」
            // -----------------view
              $view_class = $this->view_require($table_name, $action_name, $page_name);
              $v = new $view_class;
              // 配列にいれていく処理
              $array = $this->array_conversion($controller_name);
              // var_dump($array);
              $display_data = $v->display_print($template, $array, $view_class);
              return $display_data;
              }else{
                header('Location: http://localhost/bookapp/users/index/registration');
                // Modelのバリデーションに失敗  「modelからエラーが来ているときはこっち」
                // $view_class = $this->view_require($table_name, $action_name, $page_name);
                // $v = new $view_class;
                // $array = $this->array_conversion($controller_name);
                // $display_data = $v->error_print($template, $array, $view_class,$model_result);
                // return $display_data;
              }
            // $view_class = $this->view_require($table_name, $action_name, $page_name);
            // $v = new $view_class;
            // $v->header_print($template, $headerData);
          }else{
            $controller_result = '<br><h3>modelのアクションが定義されていません</h3>';
            return $controller_result;
          }
          exit;
        }
}

?>