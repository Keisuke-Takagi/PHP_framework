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
        $this->session_email = $_SESSION['EMAIL'];
  }
  public function getSessionEmail(){
    if (!isset($_SESSION)) {
      session_start();
      }
      return $this->session_email;
  }

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
  }
}
?>