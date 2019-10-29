<?php
namespace test\index;

require_once(dirname(dirname(__DIR__))."/BaseView.php");


class Firstview extends \Views\Baseview {
  public function users() {
    $users =[];
    return $users;
  }
}
?>