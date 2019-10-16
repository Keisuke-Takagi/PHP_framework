<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");

require_once(dirname(dirname(dirname(__FILE__))) . "/index/head.php");
?>
  <title>本の登録情報エラー</title>
</head>
<body>
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
              <a href="mainpage.php">メインページ</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <div class="main">
      <h1> 登録機能ページ</h1>
      <?php
      if(isset($_POST['title']) && $_POST['title'] != ""){
        header('Location: http://localhost/bookapp/books/index/mainpage');
        require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\database.php");
        $database = new Database();
        $dbh = $database->open();
        require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\\trim.php");
        $trim_class = new Trim();
        $title = $trim_class->space_trim($_POST['title']);
        $description = $trim_class->space_trim($_POST['description']);
        session_start();
        $stmt = $dbh->prepare('select * from users where email = ?');
        $stmt->execute([$_SESSION['EMAIL']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($row);
        $user_id = $row['id'];
        $_SESSION['USER_ID'] = $user_id;
        $_SESSION['EMAIL'] = $_SESSION['EMAIL'];
        // ここから登録
        $stmt = $dbh->prepare('INSERT INTO `books`(`title`, `description`, `user_id`) 
        VALUES (:title, :description, :user_id)');
        $array = array(':title' => $title, 'description' => $description, 'user_id' => $user_id);
        var_dump($array);
        $stmt->execute($array);
      }else{
        echo "本のタイトルを入力してください";
      }
      require_once(dirname(dirname(dirname(__FILE__))) . "/index/footer.php");
      ?>
  </div>