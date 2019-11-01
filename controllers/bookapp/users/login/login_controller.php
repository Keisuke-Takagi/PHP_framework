<?php
// namespace Bookapp\users\index;
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");
class Logincontroller extends Applicationcontroller {
  public function redirect_book_page(){
    header('Location: http://localhost/bookapp/books/index/mainpage');
  }

  public function user_login($action_name, $model_instance, $model_error_num){
    $e = 2;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $email = $model_instance->getEmail();
      $password = $model_instance->getPassword();
      require_once(dirname(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php");
      $database = new Database();
      $dbh = $database->open();
      $stmt = $dbh->prepare('select * from users where email = ?');
      $stmt->execute([$_POST['email']]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if(!empty($row)){
        if(password_verify($password, $row['password'])){
          $e = "";
          $model_instance->setSession($email);
          $this->redirect_book_page();
        }
      }
    }
    return $e;
  }
  public function login($table_name, $action_name, $page_name, $template){
    $template_path = "";
    $model_error_num = "";
    $model_class = $this->model_require($table_name, $action_name, $page_name);
      // モデルインスタンス作成
    $model_instance = new $model_class;
    $model_instance->setEmail($this->postData("email"));
    $a = $model_instance->getEmail();
    $model_instance->setPassword($this->postData("password"));
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $model_error_num = $model_instance->validation($table_name);

      if($model_error_num == ""){
        $model_error_num = $this->user_login($action_name, $model_instance, $model_error_num);
      }
    }
    $template_path = $template;

    if($model_error_num != "" ){
      $template_path = $this->get_error_template($template, $model_error_num);
    }
    return [
      "model_instance" => $model_instance,
      "template_path" => $template_path
    ];
  }
}

?>