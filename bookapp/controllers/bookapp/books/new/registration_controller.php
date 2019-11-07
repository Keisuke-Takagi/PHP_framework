<?php
// namespace Bookapp\books\new_form;
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");


class Registrationcontroller extends Applicationcontroller {

  public function redirect_book_page(){
    header('Location: http://localhost/bookapp/books/index/mainpage');
  }
  // 本と画像の作成
  public function create( $model_instance){

    require_once(dirname(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php");
    $database = new Database();
    $dbh = $database->open();

    // ログインユーザーのid検索
    $stmt = $dbh->prepare('select * from users where email = ?');
    $stmt->execute([$_SESSION['EMAIL']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $row['id'];

    // 本の作成
    $title = $model_instance->getTitle();
    $description = $model_instance->getDescription();
    $stmt = $dbh->prepare('INSERT INTO `books`(`title`, `description`, `user_id`) 
    VALUES (:title, :description, :user_id)');
    $array = array(':title' => $title, 'description' => $description, 'user_id' => $user_id);
    $stmt->execute($array);


    if($_FILES["upimg"]["name"] != ""){
      // 画像の作成
      $this->create_img($dbh);
    }
  }
  

  // 画像の作成(処理部分)
  private function create_img($dbh){
      // 必要な値の取得
      $book_id = $dbh->lastInsertId();
      $image_name = $_FILES["upimg"]["name"];
      $image_name = date("Y/m/d/His") . $image_name;
      $image_type = $_FILES["upimg"]["type"];
      $image_size = $_FILES["upimg"]["size"];
      $image_size = intval($image_size);
      $tmp_name = $_FILES["upimg"]["tmp_name"];
      $raw_data = file_get_contents($tmp_name);
      $raw_data = base64_encode($raw_data);

      // 作成
      $insert = "INSERT INTO images (
        image_name, image_type, image_size, raw_data, book_id) VALUES (:image_name, :image_type, :image_size, :raw_data, :book_id
      )";
      $stmt = $dbh->prepare($insert);
      $params = array(':image_name' => $image_name, ':image_type' => $image_type, ':image_size' => $image_size, ':raw_data' => $raw_data, ':book_id' => $book_id);
      $stmt->execute($params);
  }
  public function new($table_name, $action_name, $page_name, $template){
    
    $template_path = "";
    $model_error_num = "";
    $model_class = $this->model_require($table_name, $action_name, $page_name);
    $model_instance = new $model_class;
    $this->login_authentication($model_instance);
    $model_instance->setTitle($this->postData('title'));
    $model_instance->setDescription($this->postData('description'));

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $model_error_num = $model_instance->validation($table_name);
      if($model_error_num == ""){
        // エラーがない場合（作成）
        $this->create($model_instance);

        $template_path = $template;
        $this->redirect_book_page();
      }
    }
    if($_SERVER["REQUEST_METHOD"] == "GET"){
      $template_path = $template;
    }
    if($model_error_num != "" ){
      $template_path = $this->get_error_template($template, $model_error_num);
    }
    var_dump($template_path);
    return [
      'template_path' => $template_path,
      'model_instance' => $model_instance,
    ];
  }
}

?>