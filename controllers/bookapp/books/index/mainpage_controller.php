<?php
// namespace Bookapp\books\index;

require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");

class Mainpagecontroller extends Applicationcontroller {
  public function __construct(){
    if (!isset($_SESSION)) {
      session_start();
      }
    if(!isset($_SESSION['EMAIL'])){
      header('Location: http://localhost/bookapp/users/index/registration');
    }
    require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\database.php");
  }
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
                      <h1 class='my-3 ml-3'>読んだ本リスト</h1>
                      <a type='button' class='btn btn-success' style='margin: 10px 0 10px 0; height:50px;   line-height: 33px;' href='http://localhost/bookapp/books/new/registration'>読んだ本を登録する</a>
                      <div class='col-5 ml-3'>
                        <div class='card'>
                            <div class='table-responsive'>
                            <table class='table table-responsive table-bordered table-striped table-hover table-responsive' style='white-space: nowrap;'>";
    return[
      "content" => "{$content}"
    ];
  }
  public function second_content_print(){
    $content2 = '
                </tbody>
                </table>
                </div>
                </div>
                </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
                </body>';
    return [
      "content2" => "{$content2}"
    ];
  }
  // public function index(){
  //   // if (!isset($_SESSION)) {
  //   // session_start();
  //   // }
  //   if(isset($_SESSION['EMAIL'])){
  //     // $dbh = new PDO("mysql:host=127.0.0.1; dbname=test; charset=utf8", 'root','');
  //     // エラー箇所
  //     $database = new Database();
  //     $dbh = $database->open();
  //     $stmt = $dbh->prepare('select * from users where email = ? ');
  //     $stmt->execute([$_SESSION['EMAIL']]);
  //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
  //     $user_id = $row['id'];
  //     // $_SESSION['USER_ID'] = $user_id;
  //     $sql = 'select * from books where user_id = ? limit 100';
  //     $stmt2 = $dbh->prepare($sql);
  //     $stmt2->execute(array($user_id));
  //     $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
  //     // リダイレクト処理
  //     if(empty($results) ){
  //       header('Location: http://localhost/bookapp/books/new/reheadergistration');
  //     }
  //     $records = $results;
  //     }
  //     return $results;
  // }
  public function index($table_name, $action_name, $page_name, $template){
    $controller_name = get_class();
    echo $controller_name;
    if (!isset($_SESSION)) {
      session_start();
      }
      // ---------------------------------------------------------------アクション
      $dbh = new PDO("mysql:host=127.0.0.1; dbname=test; charset=utf8", 'root','');
      $database = new Database();
      $dbh = $database->open();
      $stmt = $dbh->prepare('select * from users where email = ? ');
      $stmt->execute([$_SESSION['EMAIL']]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $user_id = $row['id'];
      $sql = 'select * from books where user_id = ? limit 100';
      $stmt2 = $dbh->prepare($sql);
      $stmt2->execute(array($user_id));
      $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      var_dump($results);

      // ------------------------------------------------------------モデル
      $model_class = $this->model_require($table_name, $action_name, $page_name);
      // モデルインスタンス作成

      $model_instance = new $model_class;

      if(isset($_POST['email']) || isset($_POST['title'])){
        // セッターゲッターを使ってエラー表示に変換
        $a = $model_instance->post_setter($_POST['email'],$_POST['password']);
        $post_checked = $model_instance->post_getter();
      }
        $count = 0;
        $database = new Database();
        $dbh = $database->open();

          // アクションに対応するモデルメソッドが存在するか確認し、あればモデルアクションの実行
          $model_method_exec = $this->model_method_exist($model_class, $action_name);

          // この下はmodel_method関数内で
          if(!empty($model_method_exec)){
            // モデルが存在するとき
            // モデルの実行
            $model_result = $this->error_model_exec($model_class, $action_name, $results);
          if($model_result == "true" || !isset($model_result)){
            // -----------------view
              $view_class = $this->view_require($table_name, $action_name, $page_name);
              $array = $this->array_conversion($controller_name);
              // var_dump($array);
              $display_data = $v->display_print($template, $array, $view_class);
              return $display_data;
              }else{
              if($model_result == 2){
                // $rowのカウントが0の場合、作成ページへリダイレクト
                header('Location: http://localhost/bookapp/books/new/registration');
                return "";
              }
                // Modelのバリデーションに失敗  「modelからエラーが来ているときはこっち」
                $view_class = $this->view_require($table_name, $action_name, $page_name);
                $v = $view_class;
                $array = $this->array_conversion($controller_name);
                $display_data = $v->error_print($template, $array, $view_class,$results);
                return $display_data;
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