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
  // public function new($table_name, $action_name, $page_name, $template){
    // $controller_name = get_class();
    // echo $controller_name;
    // if (!isset($_SESSION)) {
    //   session_start();
    //   }
    //   // ------------------------------------------------------------モデルコントローラー
    //   $model_class = $this->model_require($table_name, $action_name, $page_name);
    //   // モデルインスタンス作成
    //   $model_instance = new $model_class;

    //   if(isset($_POST['email']) || isset($_POST['title'])){
    //     // セッターゲッターを使ってエラー表示に変換
    //     $a = $model_instance->post_setter($_POST['email'],$_POST['password']);
    //     $post_checked = $model_instance->post_getter();
    //   }
    //     $count = 0;
    //       $model_method_exec = $this->model_method_exist($model_class, $action_name);
    //       // この下はmodel_method関数内で
    //       if(!empty($model_method_exec)){
    //         // modelアクションが存在するとき
    //         $model_result = $this->model_exec($model_class, $action_name);
    //         echo 'model_result<br>' . $model_result;
    //         if($model_result == "true" || !isset($model_result)){
    //           // ここのtrueは   「Modelのバリデーションに成功したという意味」
    //         // -----------------view
    //           $view_class = $this->view_require($table_name, $action_name, $page_name);
    //           $v = new $view_class;
    //           // 配列にいれていく処理
    //           $array = $this->array_conversion($controller_name);
    //           // var_dump($array);
    //           $display_data = $v->display_print($template, $array, $view_class);
    //           return $display_data;
    //           }else{
    //             header('Location: http://localhost/bookapp/users/index/registration');
    //             // Modelのバリデーションに失敗  「modelからエラーが来ているときはこっち」
    //             // $view_class = $this->view_require($table_name, $action_name, $page_name);
    //             // $v = new $view_class;
    //             // $array = $this->array_conversion($controller_name);
    //             // $display_data = $v->error_print($template, $array, $view_class,$model_result);
    //             // return $display_data;
    //           }
    //         // $view_class = $this->view_require($table_name, $action_name, $page_name);
    //         // $v = new $view_class;
    //         // $v->header_print($template, $headerData);
    //       }else{
    //         $controller_result = '<br><h3>modelのアクションが定義されていません</h3>';
    //         return $controller_result;
    //       }
    //       exit;
        // }
}

?>