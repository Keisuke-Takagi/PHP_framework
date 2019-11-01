<?php
// namespace Bookapp\books\new_form;
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");


class Registrationcontroller extends Applicationcontroller{

  public function redirect_main_page(){
    header('Location: http://localhost/bookapp/books/index/mainpage');
  }

  public function create($action_name, $model_instance, $model_error_num){
    require_once(dirname(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php");
    $database = new Database();
    $dbh = $database->open();
    $stmt = $dbh->prepare('select * from users where email = ?');
    $stmt->execute([$_SESSION['EMAIL']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $row['id'];
    $title = $model_instance->getTitle();
    $description = $model_instance->getDescription();
    $stmt = $dbh->prepare('INSERT INTO `books`(`title`, `description`, `user_id`) 
    VALUES (:title, :description, :user_id)');
    $array = array(':title' => $title, 'description' => $description, 'user_id' => $user_id);
    $stmt->execute($array);
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
        $this->create($action_name, $model_instance, $model_error_num);
        $this->redirect_main_page();
      }
    }
    if($model_error_num == ""){
      $template_path = $template;
    }

    if($model_error_num != "" ){
      $template_path = $this->get_error_template($template, $model_error_num);
    }

    return [
      'template_path' => $template_path,
      'model_instance' => $model_instance,
    ];
  }
}

?>