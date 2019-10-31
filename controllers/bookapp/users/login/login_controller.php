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
    //             // Modelのバリデーションに失敗  「modelからエラーが来ているときはこっち」
    //             $view_class = $this->view_require($table_name, $action_name, $page_name);
    //             $v = new $view_class;
    //             $array = $this->array_conversion($controller_name);
    //             $display_data = $v->error_print($template, $array, $view_class,$model_result);
    //             return $display_data;
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