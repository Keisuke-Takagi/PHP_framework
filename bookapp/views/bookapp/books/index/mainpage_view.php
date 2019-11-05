<?php

// bookappとbooksは変数で定義して外部から持ってくる記述が後で必要
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");

class Mainpageview extends Baseview{
  public function php_print($tenplate, $model_results){
      $htmlStr = "";
      $num = 0;
      $viewModel = $model_results["model_instance"];
      $first_html = file_get_contents(dirname(dirname(dirname(dirname(__DIR__)))) . "\\template\bookapp\books\index\bookinfo_mainpage_template.html");
      $first_layout_path = dirname(dirname(dirname(dirname(__DIR__)))) . "\\template\bookapp\books\index\mainpage_template.html";
      $first_layout = file_get_contents($first_layout_path);
      $book_info = $viewModel->getAll();
      $book_count = $book_info["book_count"];
      $book_html = $book_info["book_html_array"];
      while($book_count > $num){
        $htmlStr .= $first_html;
        foreach ($viewModel->getKeys() as $key) {
          $htmlStr = str_replace("<<".$key .">>", $book_html[$key][$num], $htmlStr);
        }
        $num += 1;
      }

      $layout_path = (dirname(dirname(dirname(dirname(__DIR__))))."/template/bookapp/layout/index.html");
      
      $layout = file_get_contents($layout_path);

      $books_view_html = $viewModel->getBookHtmlArray();
 
      $htmlStr = str_replace("<<book_content>>", $htmlStr, $first_layout);
  
      $htmlStr = str_replace("<<contents>>", $htmlStr, $layout);

      print $htmlStr;
  }
}
?>