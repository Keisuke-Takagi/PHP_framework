<?php
// namespace Bookapp\users\index;
// require_once(dirname(dirname(dirname(__DIR__)))."/BaseView.php");

// bookappとusersは変数で定義して外部から持ってくる記述が後で必要
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/users/connect_view.php");

class Registrationview extends Baseview{
  public function php_print($template, $model_results){
    $htmlStr = file_get_contents($model_results["template_path"]);
    $layout_path = (dirname(dirname(dirname(dirname(__DIR__))))."/template/bookapp/layout/index.html");
    $layout = file_get_contents($layout_path);
    // $model_array = $viewModel->getAll();
    $viewModel = $model_results["model_instance"];
    foreach ($viewModel->getAll() as $k => $v) {
      $htmlStr = str_replace("<<".$k.">>", $v, $htmlStr);
    }
    $htmlStr = str_replace("<<contents>>", $htmlStr, $layout);
    print $htmlStr;
  }
}
// require_once(dirname(dirname(dirname(__FILE__))) . "/index/head.php");
?>

  <!-- <title>新規登録ページ</title>
</head>
<body>
  <header id="header">
    <div class="app-icons">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
          <a class='navbar-brand' href='/bookapp/users/index/registration'>READ-BOOK-RECORDER</a>
            <div class="login-icon">
              <i class="fa fa-user" id="user-login-icon"  aria-hidden="true"></i>
              <a href="../session/login">ログイン</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header> 
  
<div class="main">
    <h1> 新規登録</h1>
    <form action="../../users/create/insert" method="post" class="new-user-form">
      <td>
        <tr>
          <p>メールアドレス</p>
          <input type="text" name="email" class="form-input">
        </tr>
        <tr>
          <p>パスワード</p>
          <input type="text" name="password"class="form-input">
        </tr>
      </td>
      <button type="submit" class="btn btn-success btn-lg">新規登録</button>
    </form>
  </div> -->

<!-- // require_once(dirname(dirname(dirname(__FILE__))) . "/index/footer.php"); -->

