<?php
include dirname(__FILE__) . "/head.php"
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
              <a href="registration.php">新規登録</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
  
  <div class="main">
    <h1> ログイン </h1>
    <form action="login-function.php" method="post" class="new-user-form">
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
      <button type="submit" class="btn btn-success btn-lg">ログインする</button>
    </form>
  </div>
<?php
include dirname(__FILE__) . "/footer.php"
?>