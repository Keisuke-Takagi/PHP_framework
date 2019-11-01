<?php

require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");

class Logoutcontroller  extends Applicationcontroller{

  public function logout($table_name, $action_name, $page_name, $template){
    $this->redirect_new_user_page();
    $template_path = "";
    $model_error_num = "";
    $model_class = $this->model_require($table_name, $action_name, $page_name);
    $model_instance = new $model_class;
    $auth_info = $this->login_authentication($model_instance);
    if($auth_info != "false" ){
      if (!isset($_SESSION)) {
        session_start();
      }
      $_SESSION = array();
    }

    return [
      "model_instance" => $model_instance,
      "template_path" => $template_path,
    ];
  }
}
?>