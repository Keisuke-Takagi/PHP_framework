<?php
class BaseModel{
  private $post1;
  private $post2;
  public function __construct(){
    if (!isset($_SESSION)) {
      session_start();
      }
  }
  public function login_confirm(){
    if(isset($_SESSION['EMAIL'])){
      return "現在ログイン中です";
    }else{
      return "ログアウトされています";
    }
  }
  public function post_setter($val1, $val2){
    $this->post1 = $val1;
    $this->post2 = $val2;
  }
  public function post_getter(){
    if(empty($this->post1) || empty($this->post2)){
      return "POSTの値が空です";
    }else{
      return "";
    }
  }
}
?>