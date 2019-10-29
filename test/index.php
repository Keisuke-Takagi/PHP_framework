<?php
//print "test";
echo $_SERVER['REQUEST_URI'];

$paths = explode("/",  $_SERVER['REQUEST_URI']);
echo '<br>';
// $controller = "";
// $view = "";
$objBase = "";
//$split = "";
foreach ($paths as $number => $path ) {
  if ($number === 0) {
    continue;
  }
  if ($number > 1) {
    $objBase .= "\\";
    //$split = "\\";
  }
  //$path = $path . "\\" ;
  if (count($paths) - 1 == $number) {
    $path = ucfirst($path);
  }
  $objBase .= $path;
  //$contoller .= $split.$path;
}
echo 'これobjbase    [' . $objBase . "]   ⇒ようはlocalhostの後ろのURLだよね⇒HTDOCS直下から見た絶対パスだからファイルを呼び出すよね";
$controller = $objBase."controller";
$view = $objBase."view";
$template = strtolower($objBase)."_template.html";
echo '<br>';
echo 'これcontroller     [' . $controller . "]   ⇒事前に作ったファイルのパスを生成した <br>";
echo 'これview    [' . $view . "]   ⇒事前に作ったファイルのパスを生成した <br>";
echo 'これtemplate    [' . $template . "]   ⇒事前に作ったファイルのパスを生成 <br>";
// パスは「/」でも「\」でもいい
include "controllers\\test\\index\\first_controller.php";
include "views\\test\\index\\first_view.php";
// $controllerにはControllerのパスが入っている
$a = new $controller();
// $dispDataは特定のコントローラーファイルのクラスを実行したもの
$dispData = $a->exec();

$v = new $view();
// __DIR__ではファイルの絶対パスのみ取得⇒C:\xampp\htdocsが取得可能
$template = __DIR__."\\template\\".$template;
echo '<br >';
echo 'これ＄template   [';
echo $template;
echo '          templateファイルの絶対パス';
// Baseviewファイルからprerender 関数を呼び出している
$v->prerender($template, $dispData);
?>