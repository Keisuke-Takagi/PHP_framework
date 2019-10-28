<?php
// namespace views;

class Baseview {
  // templateの絶対パスとコントローラーの処理をもらった結果をtemplate以下の.htmliファイルにprintする関数
  // 他の子クラスでも使えるようにするためにあえてpublicプロパティを使用している
  public $count = 1;
    public function prerender($template, $dispData){
      // file_get_contentsには絶対パスが必要（呼び出し元のindex.phpで変換済み）
      $htmlStr = file_get_contents($template);
      foreach ($dispData as $key => $value) {
          // str_replaceで検索に一致した文字列を置換する（このとき配列のキーと対応したテンプレートファイル内の対応した位置に表示される）
        $htmlStr = str_replace("<<".$key.">>", $value, $htmlStr);
        print $htmlStr;
        break;
      }
    }
    public function footer_print($template, $dispData){
      echo "aa";
   }
  }
?>