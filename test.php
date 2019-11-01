<?php
require('vendor/autoload.php');
$user = new Test\User('taro');

var_dump($user->get_user_name());

?>