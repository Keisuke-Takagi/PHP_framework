<?php
// namespace Bookapp\books\index;

require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");

class Mainpagecontroller extends Applicationcontroller {
  private $session_email;
  public function __construct(){
    require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\database.php");
  }
 

  public function set_view_info($model_instance, $rows){
    $num = 0;
    $html_array = [];
    $count_book = [];
    $title = [];
    $description = [];
    $destroy_html = [];
    $edit_html = [];
    $count = count($rows);
    while($num  < $count){
      $book_title = $rows[$num]["title"];
      $book_description = $rows[$num]["description"];
      $destroy_input_html = '<input type="hidden"name="destroy" class="btn btn-danger"value="' .   $rows[$num]["id"] . '">';
      $edit_input_html = '<input type="hidden"name="edit" class="btn btn-danger" style="margin: 2px 20px;"value="' .    $rows[$num]["id"].'/'.$rows[$num]["title"].'/'.$rows[$num]["description"]. '">';
      $count_book[$num] = $num + 1;
      $title[$num] = $book_title;
      $description[$num] = $book_description;
      $destroy_html[$num] = $destroy_input_html;
      $edit_html[$num] = $edit_input_html;
      $num ++;
    }
    $html_array = ["book_title" => $title, "count" => $count_book, "description" => $description, "destroy_html" => $destroy_html, "edit_html" => $edit_html];
    $book_count = end($html_array["count"]);
    $model_instance->setBookCount($book_count);
    $model_instance->setBookHtmlArray($html_array);
    // var_dump($html_array);
  }
  
  public function index($table_name, $action_name, $page_name, $template){
    $template_path = "";
    $model_error_num = "";
    $model_class = $this->model_require($table_name, $action_name, $page_name);
    $model_instance = new $model_class;
    $this->login_authentication($model_instance);
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
    // ------------------------------------ここから

    foreach ($rows as $row) {
      echo '<br>';
      echo $row["id"];
      $book_id = $row["id"];
      $select = 'select * from images where book_id = ? ';
      $stmt = $dbh->prepare($select);
      $stmt->execute(array($book_id));
      $row_img = $stmt->fetch(PDO::FETCH_ASSOC);
      var_dump($row_img["id"]);
      if($row_img != ""){
        // header('Content-Type: image/jpeg;');
        echo 'あああああああああ';
        // $row_img["raw_data"] = imagecreatetruecolor(700, 300);
        // $img = base64_decode($row_img["raw_data"]);
        // $img = imagecreatefromstring($row_img["raw_data"]);
        // print($row_img["raw_data"]);
        // echo '<img src="'.$row_img["raw_data"] .'">';
        // imagejpeg($img);
      }
    }
    // ------------------------------ここまで編集
    $this->set_view_info($model_instance, $rows);
    $template_path = $template;
    return [
      "model_instance" => $model_instance,
      "template_path" => $template_path,
    ];
  }
}
?>