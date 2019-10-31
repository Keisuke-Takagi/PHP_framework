<?php
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");

class Destroycontroller  extends Applicationcontroller{
  public function redirect_main_page(){
    header('Location: http://localhost/bookapp/books/index/mainpage');
  }

  public function delete($table_name, $action_name, $page_name, $template){
    $template_path = "";
    $model_error_num = "";
    $model_class = $this->model_require($table_name, $action_name, $page_name);
      // モデルインスタンス作成
    $model_instance = new $model_class;
    $auth_info = $this->login_authentication($model_instance);
    if($auth_info != "false" && $_SERVER["REQUEST_METHOD"] == "POST"){
      $model_instance->setPostDestroy($this->postData('destroy'));
      $id = intval($model_instance->getPostDestroy());
      require_once(dirname(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php");
      $database = new Database();
      $dbh = $database->open();
      $stmt2 = $dbh->prepare('delete from books where id = ?');
      $stmt2->execute([$id]);
      $this->redirect_main_page();
    }else{
      $this->redirect_new_user_page();
    }
    return [
      "model_instance" => $model_instance,
      "template_path" => $template_path,
    ];
          }
        
}