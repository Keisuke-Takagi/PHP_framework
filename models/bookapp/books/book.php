<?php

require_once( dirname(__DIR__)  . "/BaseModel.php");
class Bookmodel extends BaseModel{
  public function __construct(){
    // require_once(dirname(dirname(dirname(__DIR__))) . "\\views\\database.php");
    if (!isset($_SESSION)) {
      session_start();
      }
    if(isset($_POST['email'])){
      if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $_SESSION['ERROR'] = 1;
        // echo '入力された値が不正です。';
      }
      if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{5,20}+\z/i', $_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        return $password;
      }else {
        // echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ5文字以上で設定してください。\n前のページへ戻る';
        $_SESSION['ERROR'] = 3;
        return false;
      }
    }
  }
  public function getAll(){
    return "";
  }
  public function index($records){
    // if(!isset($_SESSION['EMAIL'])){
    //   header('Location: http://localhost/bookapp/users/index/registration');
    // }
    $count = count($records);
    if($count >= 1 ){
    $_SESSION['COUNT'] = $count;
      // var_dump($records);

      foreach ($records as $row) {
        $error = 0;
        $book_id = var_dump($row["id"]);
        $book_title = var_dump($row["title"]);
        $book_user_id = var_dump($row["user_id"]);
        if(isset($book_id) && isset($book_title) && isset($book_user_id)){
          $_SESSION['USER_ID'] = $user_id;
        }else{
          $error = 1;
          return $error;
          $error = $book_title . "のデータが不正です"; 
        }
      }
    }else{
      $error = 2;
      return $error;
    }
  }
  public function new(){
    if (!isset($_SESSION)) {
      session_start();
      }
    if(!isset($_SESSION['EMAIL'])){
      return 1;
    }
  }


  public function create(){
    $book_title = $_POST['title'];
    $book_description = $_POST['description'];
    if(empty($book_title) ){
      return  2;
      if(!isset($_SESSION['EMAIL'])){
        return 1;
      }
    }else{
    }
  }
  public function edit(){
    $name = $_SESSION['COUNT'];
    $book_id = $_POST[$name];
        require_once(dirname(dirname(dirname(__DIR__))) . "\\views\\database.php");
    $database = new Database();
    $dbh = $database->open();
    $stmt = $dbh->prepare('select * from books where id = ? ');
    $stmt->execute([$book_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC); 
    $_SESSION['BOOK_ID'] = $row["id"];
  }
  public function update(){
        // require_once(dirname(dirname(dirname(__DIR__))) . "\\views\\database.php");
    if($_SESSION['EMAIL'] && $_SESSION['BOOK_ID']){
    $database = new Database();
    $dbh = $database->open();
    $stmt = $dbh->prepare('select * from books where id = ?');
      $stmt->execute([$_SESSION['BOOK_ID']]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if(!empty($row)){
        return "true";
      }else{
       return "false"; 
      }
    }else{
      return "false";
    }
  }
  public function delete(){
    
    if(!isset($_POST[$_SESSION['COUNT']])){
      return 1;
    }
    if(!isset($_SESSION['EMAIL'])){
      return 2;
    }

  }
}
?>