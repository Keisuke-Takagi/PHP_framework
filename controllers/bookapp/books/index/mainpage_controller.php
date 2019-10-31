<?php
// namespace Bookapp\books\index;

require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");

class Mainpagecontroller extends Applicationcontroller {
  private $session_email;
  public function __construct(){
    $email = "";
    $this->setSessionEmail();
    $email = $this->getSessionEmail();
    if($email == ""){
      header('Location: http://localhost/bookapp/users/index/registration');
    }
    require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\database.php");
  }
 
  public function setSessionEmail(){
      if (!isset($_SESSION)) {
      session_start();
      }
      echo $_SESSION['EMAIL'];
      // if(isset($_SESSION['EMAIL'])){
        $this->session_email = $_SESSION['EMAIL'];
      // }
  }
  public function getSessionEmail(){
    if (!isset($_SESSION)) {
      session_start();
      }
      return $this->session_email;
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
  public function view_return($rows){
    $num = 0;
    $html_array = [];
    $count_book = [];
    $title = [];
    $description = [];
    $destroy_html = [];
    $edit_html = [];
    $count = count($rows);
    $actionexec = $rows;
    while($num  < $count){
      // ここから表示機能
      $book_title = $rows[$num]["title"];
      $book_description = $rows[$num]["description"];
      $destroy_input_html = '<input type="hidden"name="destroy" class="btn btn-danger"value="' .   $actionexec[$num]["id"] . '">';
      $edit_input_html = '<input type="hidden"name="edit" class="btn btn-danger" style="margin: 2px 20px;"value="' .    $actionexec[$num]["id"].'/'.$actionexec[$num]["title"].'/'.$actionexec[$num]["description"]. '">';
      $count_book[$num] = $num + 1;
      $title[$num] = $book_title;
      $description[$num] = $book_description;
      $destroy_html[$num] = $destroy_input_html;
      $edit_html[$num] = $edit_input_html;
      $num ++;
    }
    $html_array = ["book_title" => $title, "count" => $count_book, "description" => $description, "destroy_html" => $destroy_html, "edit_html" => $edit_html];
      return $html_array;
  }
  
  public function index($table_name, $action_name, $page_name, $template){
    $template_path = "";
    $model_error_num = "";
    $model_class = $this->model_require($table_name, $action_name, $page_name);
      // モデルインスタンス作成
    $model_instance = new $model_class;
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
      $rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
      $book_html_array = $this->view_return($rows);
      $book_count = end($book_html_array["count"]);
      $model_instance->setBookCount($book_count);
      $model_instance->setBookHtmlArray($book_html_array);
      $template_path = $template;
    return [
      "model_instance" => $model_instance,
      "template_path" => $template_path,
    ];

    // $controller_name = get_class();
    // echo $controller_name;
    // if (!isset($_SESSION)) {
    //   session_start();
    //   }
    //   // ---------------------------------------------------------------アクション
    //   $dbh = new PDO("mysql:host=127.0.0.1; dbname=test; charset=utf8", 'root','');
    //   $database = new Database();
    //   $dbh = $database->open();
    //   $stmt = $dbh->prepare('select * from users where email = ? ');
    //   $stmt->execute([$_SESSION['EMAIL']]);
    //   $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //   $user_id = $row['id'];
    //   $sql = 'select * from books where user_id = ? limit 100';
    //   $stmt2 = $dbh->prepare($sql);
    //   $stmt2->execute(array($user_id));
    //   $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    //   var_dump($results);

    //   // ------------------------------------------------------------モデル
    //   $model_class = $this->model_require($table_name, $action_name, $page_name);
    //   // モデルインスタンス作成

    //   $model_instance = new $model_class;

    //   if(isset($_POST['email']) || isset($_POST['title'])){
    //     // セッターゲッターを使ってエラー表示に変換
    //     $a = $model_instance->post_setter($_POST['email'],$_POST['password']);
    //     $post_checked = $model_instance->post_getter();
    //   }
    //     $count = 0;
    //     $database = new Database();
    //     $dbh = $database->open();

    //       // アクションに対応するモデルメソッドが存在するか確認し、あればモデルアクションの実行
    //       $model_method_exec = $this->model_method_exist($model_class, $action_name);

    //       // この下はmodel_method関数内で
    //       if(!empty($model_method_exec)){
    //         // モデルが存在するとき
    //         // モデルの実行
    //         $model_result = $this->error_model_exec($model_class, $action_name, $results);
    //       if($model_result == "true" || !isset($model_result)){
    //         // -----------------view
    //           $view_class = $this->view_require($table_name, $action_name, $page_name);
    //           $array = $this->array_conversion($controller_name);
    //           // var_dump($array);
    //           $display_data = $v->display_print($template, $array, $view_class);
    //           return $display_data;
    //           }else{
    //           if($model_result == 2){
    //             // $rowのカウントが0の場合、作成ページへリダイレクト
    //             header('Location: http://localhost/bookapp/books/new/registration');
    //             return "";
    //           }
    //             // Modelのバリデーションに失敗  「modelからエラーが来ているときはこっち」
    //             $view_class = $this->view_require($table_name, $action_name, $page_name);
    //             $v = $view_class;
    //             $array = $this->array_conversion($controller_name);
    //             $display_data = $v->error_print($template, $array, $view_class,$results);
    //             return $display_data;
    //           }
    //         // $view_class = $this->view_require($table_name, $action_name, $page_name);
    //         // $v = new $view_class;
    //         // $v->header_print($template, $headerData);
    //       }else{
    //         $controller_result = '<br><h3>modelのアクションが定義されていません</h3>';
    //         return $controller_result;
    //       }
    //       exit;
        }
}
?>