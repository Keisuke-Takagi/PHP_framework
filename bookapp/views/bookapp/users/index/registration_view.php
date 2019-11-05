<?php
// bookappとusersは変数で定義して外部から持ってくる記述が後で必要
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/users/connect_view.php");

class Registrationview extends Baseview{
  public function php_print($template, $model_results){
    $this->print_html($template, $model_results);
  }
}

?>



