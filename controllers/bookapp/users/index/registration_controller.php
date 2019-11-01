<?php
// namespace Bookapp\users\index;
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");

class Registrationcontroller extends Applicationcontroller {

  public function redirect_book_page(){
    header('Location: http://localhost/bookapp/books/index/mainpage');
  }

  public function create($action_name, $model_instance, $model_error_num){
        var_dump(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php";
        require_once(dirname(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php");
        $database = new Database();
        $dbh = $database->open();
        if(isset($_POST['email'])){
          $db_emails = "SELECT email FROM users";
          // Databaseでメールの検索
          foreach ($dbh->query($db_emails, PDO::FETCH_BOTH) as $value) {
            if($value["email"] == $_POST['email']){
              $model_error_num = 2;
            }
          }
        }
      if($model_error_num == ""){
        $model_method = __FUNCTION__;
        $model_error_num = $model_instance->$model_method();
      }
    if($model_error_num == "true"){
      $email = $model_instance->getEmail();
      $model_instance->setSession($email);
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $insert = "INSERT INTO users (
        email, password) VALUES (:email,:password
      )";
      $stmt = $dbh->prepare($insert);
      $params = array(':email' => $email, ':password' => $password);
      $stmt->execute($params);
      $this->redirect_book_page();
    }
    return $model_error_num;
  }
  
  public function index($table_name, $action_name, $page_name, $template){
    $template_path = "";
    $model_error_num = "";
    $model_class = $this->model_require($table_name, $action_name, $page_name);
      // モデルインスタンス作成
    $model_instance = new $model_class;
    $model_instance->setEmail($this->postData('email'));
    $model_instance->setPassword($this->postData('password'));
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      // POSTされた値が空かどうかを確認する共通のバリデーション
      $model_error_num =  $model_instance->validation($table_name);
      if($model_error_num == ""){
        $model_error_num = $this->create($action_name, $model_instance, $model_error_num);
      }
    }
    if($model_error_num == ""){
      $template_path = $template;
    }

    if($model_error_num != "" || $model_error_num == "true"){
      $template_path = $this->get_error_template($template, $model_error_num);
    }

    return [
      "model_instance" => $model_instance,
      "template_path" => $template_path
    ];
  }
}

?>