<?php
// namespace Bookapp\books\edit;
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");
class Editcontroller extends Applicationcontroller {
  public function redirect_book_page(){
    header('Location: http://localhost/bookapp/books/index/mainpage');
  }
  // public function setSessionBookId($val){
  //   if (!isset($_SESSION)) {
  //     session_start();
  //   }
  //   $_SESSION['BOOK_ID'] = $val;
  // }
  // public function content_print(){
  //   if (!isset($_SESSION)) {
  //     session_start();
  //   }
  //   $name = $_SESSION['COUNT'];
  //   $book_id = $_POST[$name];
  //   require_once(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\views\\database.php");
  //   $database = new Database();
  //   $dbh = $database->open();
  //   $stmt = $dbh->prepare('select * from books where id = ? ');
  //   $stmt->execute([$book_id]);
  //   $row = $stmt->fetch(PDO::FETCH_ASSOC); 
  //   var_dump($row);
  //   var_dump($row['title']);
  //   $content = '  <title>登録情報編集</title>
  //                 </head>
  //                 <body>
  //                 <body>
  //                   <header id="header">
  //                     <div class="app-icons">
  //                       <nav class="navbar navbar-default">
  //                         <div class="container-fluid">
  //                           <div class="navbar-header">
  //                             <a class="navbar-brand" href="registration.php">READ-BOOK-RECORDER</a>
  //                             <div class="login-icon">
  //                               <i class="fa fa-user" id="user-login-icon"  aria-hidden="true"></i>
  //                               <a href="../../../bookapp/users/session/logout">ログアウト</a>
  //                               <a href="mainpage.php">メインページへ</a>
  //                             </div>
  //                           </div>
  //                         </div>
  //                       </nav>
  //                     </div>
  //                   </header>
  //                   <div class="main">
  //                   <h1>本登録情報編集</h1>
  //                     <form action="../../books/update/update" method="post" class="edit-book-form">
  //                     <td>
  //                       <div class="book-edit-box__title">
  //                           <label>本のタイトル</label>
  //                           <input type="text" name="title" class="form-input" value="sscanf">
  //                       </div>
  //                       <div class="book-edit-box__description">
  //                           <label>感想・要約</label>
  //                           <textarea name="description" cols="20" rows="10" class="form_book_description">'
  //                           ."{$row['description']}".
  //                           '</textarea>
  //                       </div>
  //                     </td>
  //                      <button type="submit" class="btn btn-success btn-lg">編集を反映する</button>
  //                   </form>
  //                 </div>';
  //   return [
  //     "content" => "{$content}"
  //   ];
  // }
  public function update($model_instance){
    $e = 2;
    $id = $model_instance->getId();
    $title = $model_instance->getTitle();
    $description = $model_instance->getDescription();
    $id = intval($id);
    if($title != ""){
    require_once(dirname(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php");
    $database = new Database();
    $dbh = $database->open();
    $stmt = $dbh->prepare('UPDATE books SET  title = :title, description = :description WHERE id = :id');
    $stmt->bindValue(':id',$id, PDO::PARAM_INT);
    $stmt->bindValue(':title',$title, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->execute();
    $e = "";
    $this->redirect_book_page();
    }
    return $e;
  }
  
  public function edit($table_name, $action_name, $page_name, $template){
    $template_path = "";
    $model_error_num = "";
    $post_info = "";
    $title = "";
    $template_path = $template;

    $model_class = $this->model_require($table_name, $action_name, $page_name);
    $model_instance = new $model_class;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
    $model_instance->setPostEdit($this->postData('edit'));
    $index_post_val = $model_instance->getPostEdit();
    $model_instance->setId($this->postData('id'));
    $model_instance->setTitle($this->postData('title'));
    $model_instance->setDescription($this->postData('description'));
    $model_error_num = $model_instance->editValidation($index_post_val);
    var_dump($index_post_val);
    if($index_post_val != ""){
      $book_array = explode("/", $index_post_val);
      $model_instance->setId($book_array[0]);
      $model_instance->setTitle($book_array[1]);
      $model_instance->setDescription($book_array[2]);
    }
    if($index_post_val == ""){
      $model_error_num = $this->update($model_instance, $model_error_num);
    }

  }

  if($_SERVER["REQUEST_METHOD"] != "POST"){
    $this->redirect_book_page();
  }
  if($model_error_num != ""){
    $template_path = $this->get_error_template($template, $model_error_num, $model_error_num);
  }
  return [
    "model_instance" => $model_instance,
    "template_path" => $template_path,
  ];
    // $controller_name = get_class();
    // echo $controller_name;
    // if (!isset($_SESSION)) {
    //   session_start();
    //   }
    //   // ------------------------------------------------------------モデルコントローラー
    //   $model_class = $this->model_require($table_name, $action_name, $page_name);
    //   $model_instance = new $model_class;

    //   if(isset($_POST['email']) || isset($_POST['title'])){
    //     // セッターゲッターを使ってエラー表示に変換
    //     $a = $model_instance->post_setter($_POST['email'],$_POST['password']);
    //     $post_checked = $model_instance->post_getter();
    //   }
    //       // アクションに対応するモデルメソッドが存在するか確認
    //       $model_method_exec = $this->model_method_exist($model_class, $action_name);
    //       if(!empty($model_method_exec)){
    //         // modelアクションが存在するとき
    //         // $model_result = $this->model_exec($model_class, $action_name);
    //         if($model_result == "true" || !isset($model_result)){

    //         // -----------------view
    //           $view_class = $this->view_require($table_name, $action_name, $page_name);
    //           $v = new $view_class;
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
    //       }else{
    //         $controller_result = '<br><h3>modelのアクションが定義されていません</h3>';
    //         return $controller_result;
    //       }


    }
}

?>