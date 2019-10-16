<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/index/head.php");
?>
  <title>登録更新ページ</title>
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
              <a href="mainpage.php">メインページへ</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <title>編集機能ページ</title>
  </header>
  <div class="main">
    <h1>編集機能ページ</h1>
    <?php
    if (!isset($_SESSION)) {
      session_start();
    }
    var_dump($_POST["description"]);
    var_dump($_POST["title"]);
    echo $_SESSION['BOOK_ID'];
    if(isset($_SESSION['EMAIL']) && isset($_SESSION['BOOK_ID'])){header('Location: http://localhost/bookapp/books/index/mainpage');
      require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\\trim.php");
      include_once 'trim.php';
      $trim_class = new Trim;
      $title = $trim_class->space_trim($_POST['title']);
      $description = $trim_class->space_trim($_POST['description']);
      require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\database.php");
      $database = new Database();
      $dbh = $database->open();
      $stmt = $dbh->prepare('UPDATE books SET  title = :title, description = :description WHERE id = :id');
      $stmt->bindValue(':id', $_SESSION['BOOK_ID'], PDO::PARAM_INT);
      $stmt->bindValue(':title',$title, PDO::PARAM_STR);
      $stmt->bindValue(':description', $description, PDO::PARAM_STR);
      $stmt->execute();
    }else{
      echo "エラー";
    }
    ?>
  </div>