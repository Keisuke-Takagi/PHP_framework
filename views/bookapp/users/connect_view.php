<?php
class Baseview {
    public function header_print($template, $headerData){
      $htmlStr = file_get_contents($template);
      foreach ($headerData as $key => $value) {
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
    // model_print関数はmodelを使ったときだけ呼ぶ
    public function content_model_print($template, $contentData, $error){
      $htmlStr = file_get_contents($template);
      foreach ($contentData as $key => $value) {
        $htmlStr = str_replace("<<". $key . ">>", $value, $htmlStr);
      }
      $htmlStr = str_replace("<<", "<", $htmlStr);
      $htmlStr = str_replace(">>", ">", $htmlStr);

      print $htmlStr;
      // $errorはモデルの処理結果
      echo  $error;
    }
    
    public function second_content_print($template, $contentData){
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
      public function display_print($template, $headerData, $view_class){

        $htmlStr = file_get_contents($template);
        foreach ($headerData as $key => $value) {
          $htmlStr = str_replace("<<".$key.">>", $value, $htmlStr);
        }
        $htmlStr = str_replace("<<", "<", $htmlStr);
        $htmlStr = str_replace(">>", ">", $htmlStr);
        print $htmlStr;
      }
      public function error_print($template, $headerData,$view_class, $error){
        // echo '<br>$error⇒' . $error;
        $view_instance = new $view_class();
        $htmlStr = file_get_contents($template);
        foreach ($headerData as $key => $value) {
          $htmlStr = str_replace("<<".$key.">>", $value, $htmlStr);
        }
        $e = $view_instance->php_error_print($error);
        $htmlStr = str_replace("<<"."error".">>", $e ,$htmlStr);
        $htmlStr = str_replace("<<", "<", $htmlStr);
        $htmlStr = str_replace(">>", ">", $htmlStr);
        print $htmlStr;
      }
}


?>