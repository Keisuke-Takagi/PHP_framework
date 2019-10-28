<?php
require_once( dirname(__DIR__)  . "/BaseModel.php");
class Usermodel extends Basemodel{
  public function __construct(){
    // if(isset($_POST['email'])){
    //   $_SESSION['ERROR'] = 3;
    //   $email = $_POST['email'];
    //   if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    //     $_SESSION['ERROR'] = 2;
    //     echo '入力された値が不正です。';
    //   }else{
    //     $email = $_POST['email'];
    //   }
    //   if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{3,20}+\z/i', $_POST['password'])) {
    //     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    //   } else {
    //     echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ5文字以上で設定してください。<br >前のページへ戻る';
    //     $_SESSION['ERROR'] = 3;
    //     return false;
    //   }
    // }
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
  public function __set($name, $value){
    if($name =="args_count"){
      // 関数に合わせたメソッド名のメソッドを作成する記述
    }
  }
  public function __get($name){

  }
  public function new(){
    // 新規登録フォーム入力処理
  }
  public function post_auth_create(){
    
  }

  public function setter_create($val1, $val2){
    $this->email = $val1;
    $this->password = $val2;
  }
  public function create(){
    $array = [];
    if (!isset($_SESSION)) {
      session_start();
      }
    // ユーザー登録時の認証全般
    $count = 0;
    var_dump(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php";
    require_once(dirname(dirname(dirname(__DIR__))) . "\\views\\database.php");
    $database = new Database();
    $dbh = $database->open();
    if(isset($_POST['email'])){
      $db_emails = "SELECT email FROM users";
      // query()で初めてDB検索が実行
      foreach ($dbh->query($db_emails, PDO::FETCH_BOTH) as $value) {
        if($value["email"] == $_POST['email']){
          $array["count"] = 2;
          $array["email"] = $_POST['email'];
          return $array;
        }
      }
      if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $count = 1;
        // echo '入力された値が不正です。';
      }
      if ($count == 0 && preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{5,20}+\z/i', $_POST['password'])) {
        // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $_SESSION['EMAIL'] = $_POST['email'];
        return "true";
      }else {
        // echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ5文字以上で設定してください。\n前のページへ戻る';
        if($count == 1){
          $count = 4;
          // echo '[入力情報不適]入力された値が不正<br>[入力情報不適]パスワードは・・';
          return $count;
        }else{
          $count = 3;
          return $count;
        }
      }
    }
  }
  public function login_function_erorr($e){
    var_dump($e);
    return "false";
  }
  public function login(){
    // userログイン処理
  }
  public function index(){
    if(!isset($_SESSION)){
      session_start();
    }
    if(isset($_SESSION['EMAIL'])){
      return 1;
    }
  }
  public function logout(){
  }
  public function login_function($e){
    if (!isset($_SESSION)) {
      session_start();
      }
    if($e == 0){
      $_SESSION['EMAIL'] = $_POST['email'];
      return "true";
    }else{
      return "false";
    }
  //   require_once(dirname(dirname(dirname(__DIR__))) . "\\views\\database.php");
  //   $database = new Database();
  //   $dbh = $database->open();
  //   $stmt = $dbh->prepare('select * from users where email = ?');
  //   $stmt->execute([$_POST['email']]);
  //   $row = $stmt->fetch(PDO::FETCH_ASSOC);
  //   if(empty($row)){
  //     echo '<br>$rowなし'; 
  //   }else {
  //     $password = $_POST['password'];
  //     if (password_verify($password, $row['password'])) {
  //       $_SESSION['EMAIL'] = $_POST['email'];
  //     }else{
  //       echo 'パスワードが違う';
  //     }
  //     echo '<br> $row あり';
  //     var_dump($row);
  //     var_dump($row['password']);
  //   }
  }
}

?>