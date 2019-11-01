<?php
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");


class Insertcontroller extends Applicationcontroller {
  public function postData($key,$defaultValue = ""){
    $val = "";
    if(array_key_exists($key, $_POST)){
      $val = $_POST[$key];
    }
    return $val;
  }
  public function redirect_registration(){
    if($this->postData('email') == "" || $this->postData('password') == ""){
      header('Location: http://localhost/bookapp/users/index/registration');
      $template_path = $this->get_error_template($template, $model_error_num);
    };

  }
  public function create($table_name, $action_name, $page_name, $template){
    // ユーザーに関する作成の論理処理を書くところ
    $model_result = "";
    $template_path = "";
    $model_error_num = "";
    $this->redirect_registration();
    $model_class = $this->model_require($table_name, $action_name, $page_name);
    $model_instance = new $model_class;
    $model_instance->setEmail($this->postData('email'));
    $model_instance->setPassword($this->postData('password'));
    $model_result = $this->model_exec($model_class, $action_name);
    return [
      "model_instance" => $model_instance,
      "template_path" => $template_path
    ];
    



    if (!isset($_SESSION)) {
      session_start();
      }
      echo '<h1>insertのview</h1>';
      echo  '<h2><br>これemail'. $_POST['email'] . '</h2>';
      // ------------------------------------------------------------モデルコントローラー
      $model_class = $this->model_require($table_name, $action_name, $page_name);
      // モデルインスタンス作成
      $model_result = $this->model_exec($model_class, $action_name);
      $model_instance = new $model_class;

      if(isset($_POST['email']) || isset($_POST['title'])){
        // セッターゲッターを使ってエラー表示に変換
        $a = $model_instance->post_setter($_POST['email'],$_POST['password']);
        $post_checked = $model_instance->post_getter();
      }
        $count = 0;
        require_once(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\views\\database.php");
        echo "<br>" . dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\views\\database.php";
        $database = new Database();
        $dbh = $database->open();
          $model_method_exec = $this->model_method_exist($model_class, $action_name);
          // この下はmodel_method関数内で
          if(!empty($model_method_exec)){
            // modelアクションが存在するとき
            $model_result = $this->model_exec($model_class, $action_name);
            // echo 'model_result<br>' . $model_result;
            if(is_array($model_result) != "Arraybool(true)" && $model_result == "true" || $model_result == NULL){
              // ここのtrueは   「Modelのバリデーションに成功したという意味」
              $email = $_POST['email'];
              $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
              $insert = "INSERT INTO users (
                email, password) VALUES (:email,:password
              )";
              $stmt = $dbh->prepare($insert);
              $params = array(':email' => $email, ':password' => $password);
              $stmt->execute($params);
              // 配列に入れていく処理
            // -----------------view
              $view_class = $this->view_require($table_name, $action_name, $page_name);
              
              $array = $this->array_conversion($controller_name);
              // var_dump($array);
              $display_data = $v->display_print($template, $array, $model_result);
              return $display_data;
              }else{
                // Modelのバリデーションに失敗  「modelからエラーが来ているときはこっち」
                $view_class = $this->view_require($table_name, $action_name, $page_name);
                $v = new $view_class;
                $array = $this->array_conversion($controller_name);
                $display_data = $v->error_print($template, $array, $view_class,$model_result);
                return $display_data;
              }
          }else{
            $controller_result = '<br><h3>modelのアクションが定義されていません</h3>';
            return $controller_result;
          }
            exit;
            }
}

?>