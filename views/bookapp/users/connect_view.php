<?php
class Baseview {
  // templateの絶対パスとコントローラーの処理をもらった結果をtemplate以下の.htmliファイルにprintする関数
  // 他の子クラスでも使えるようにするためにあえてpublicプロパティを使用している
    public function prerender($template, $dispData){
      $htmlStr = file_get_contents($template);
      foreach ($dispData as $key => $value) {
        $htmlStr = str_replace("<<".$key.">>", $value, $htmlStr);
      }
      $htmlStr = str_replace("<<", "<", $htmlStr);
      $htmlStr = str_replace(">>", ">", $htmlStr);
      print $htmlStr;
    }
    public function content_print($template, $contentData){
      $htmlStr = file_get_contents($template);
      foreach ($contentData as $key => $value) {
        $htmlStr = str_replace("<<". $key . ">>", $value, $htmlStr);
      }
      $htmlStr = str_replace("<<", "<", $htmlStr);
      $htmlStr = str_replace(">>", ">", $htmlStr);
      print $htmlStr;
    }
      public function footer_print($template, $footerData){
        $htmlStr = file_get_contents($template);
        $count = 0;
        foreach ($footerData as $key => $value) {
          $htmlStr = str_replace("<<".$key.">>", $value, $htmlStr);
        }
        $htmlStr = str_replace("<<", "<", $htmlStr);
        $htmlStr = str_replace(">>", ">", $htmlStr);
        print $htmlStr;
      }
}
class Mainpageview extends Baseview{
  public function users() {
    $users = [];
    return $users;
  }
}
class Registrationview extends Baseview{
  public function header_show($header_data) {
    echo '<br>';
    var_dump($header_data);
    echo $header_data;
  }
}
class Insertview extends Baseview{
  public function users() {
    $users = [];
    return $users;
  }
}
class Loginview extends Baseview{
  public function users() {
    $users = [];
    return $users;
  }
}
?>