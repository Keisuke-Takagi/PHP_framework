<?php
require_once( dirname(__DIR__)  . "/BaseModel.php");
class Usermodel extends Basemodel{
  
  public $email;
  public $password;
  public $error_message;
  public $session_email;
  
  public function __construct(){

  }

  public function setEmail($val){
    $this->email = $val;
  }

  public function getEmail(){
    return $this->email;
  }

  public function setPassword($val){
    $this->password = $val;
  }

  public function getPassword(){
    return $this->password;
  }
  public function setSession($val){
    if (!isset($_SESSION)) {
      session_start();
      }
    $_SESSION['EMAIL'] = $val;
    $this->session_email = $val;
  }
  
  public function getAll(){
    return [
      'email' => $this->email,
      'password' => $this->password,
      'error_message' => $this->error_message
    ];
  }

  public function __set($name, $value){
    if($name =="args_count"){
      // 関数に合わせたメソッド名のメソッドを作成する記述
    }
  }

  public function setter_create($val1, $val2){
    $this->email = $val1;
    $this->password = $val2;
  }

  public function create(){
    if(!isset($_SESSION)){
      session_start();
    }
    $count = "";
    if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $count = 3;
    }
    if ($count == "" && preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{5,20}+\z/i', $_POST['password'])) {
      return "true";
    }
    return $count;
  }
}

?>