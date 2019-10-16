<?php
namespace bookapp\index;
require_once(dirname(dirname(__DIR__))."/BaseView.php");

class Registrationview extends \Views\Baseview{
  public function users() {
    $users = [];
    return $users;
  }
}

require_once(dirname(dirname(__FILE__)) . "/index/head.php");
?>
  <title>新規登録ページ</title>
</head>
<body>
  <header id="header">
    <div class="app-icons">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="registration.php">READ-BOOK-RECORDER</a>
            <div class="login-icon">
              <i class="fa fa-user" id="user-login-icon"  aria-hidden="true"></i>
              <a href="login.php">ログイン</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
  
  <div class="main">
    <h1> 新規登録</h1>
    <form action="insert.php" method="post" class="new-user-form">
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
  </div>
<?php
include (dirname(dirname(__FILE__)) . "/index/footer.php");
?>