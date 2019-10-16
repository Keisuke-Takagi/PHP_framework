<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/index/head.php");
?>
<title>読んだ本を登録する</title>
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
              <a href="../../../bookapp/users/session/logout">ログアウト</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <p>
<?php
  if (!isset($_SESSION)) {
  session_start();
  echo $_SESSION['EMAIL'];
  }else{
    echo $_SESSION['EMAIL'];
  }
  // if(isset($_SESSION['EMAIL'])){
  //   echo "This is main page";
  // }else{header('Location: http://localhost/registration.php');}
?>
</p>
<body>
    <div class="contents_main">
    <h1> 読んだ本登録フォーム</h1>
    <form action="http://localhost/bookapp/books/create/insert" method="post" class="new-user-form">
      <td>
        <tr>
          <p>本のタイトル</p>
          <input type="text" name="title"" class="form-input">
        </tr>
        <tr>
          <p>感想・要約</p>
          <textarea name="description" cols="20" rows="10" class="form_book_description"></textarea>
        </tr>
      </td>
      <button type="submit" class="btn btn-success btn-lg">本の登録</button>
    </form>
    </div>
</body>