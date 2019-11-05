<?php
class Applicationcontroller {

  public function model_require($model_url, $action_name, $page_name){
    $model_name = rtrim($model_url, 's');
    require_once(dirname(dirname(__DIR__)) . "/models/bookapp/" . $model_url. "/" . $model_name . ".php");
    $model_class = ucfirst($model_name) . "model";
    return $model_class;
  }
  public function view_require($model_url, $action_name, $page_name){
    require_once(dirname(dirname(__DIR__)) . '\\view_require.php');
    $view_path = (dirname(dirname(__DIR__)) . "/views/bookapp/" . $model_url . "/" . $action_name . "/" . $page_name . "_view.php");
    $view_class = ucfirst($page_name) . "view";
    $v = new makeviewinstance;
    $v = $v->return_instance($view_class, $view_path);
    return $v;
  }

  public function get_error_template($template_path, $error_num){

    $array_template = explode("/", $template_path);
    $template_path = "";
    foreach ($array_template as $num => $val) {
      if($num == 5){
        $template_path .= "error_". $error_num . "_". $val;
      }
      if($num != 5){
        $template_path .= $val . "/";
      }
    }
    return $template_path;
  }
  public function postData($key,$defaultValue = ""){
    $val = "";
    if(array_key_exists($key, $_POST)){
      $val = $_POST[$key];
    }
    return $val;
  }

  public function redirect_new_user_page(){
    header('Location: http://localhost/bookapp/users/index/registration');
  }

  public function login_authentication($model_instance){
    $e = "";
    $auth_user_error = $model_instance->Auth_user();
    if($auth_user_error != ""){
      $this->redirect_new_user_page();
      $e = "false";
    }
    return $e;
  }
}
 
?>