<?php
include dirname(__FILE__) . "/head.php"
?>
  <title>新規登録情報エラー</title>
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
              <a href="login.php">ログイン</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <div class="main">
  <p>
  <a href="registration.php">
  <?php
    $count = 0;
    require_once("database.php");
    $database = new Database();
    $dbh = $database->open();
    $dbh = new PDO("mysql:host=127.0.0.1; dbname=test; charset=utf8", 'root','');
    if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $count = 1;
      echo '入力された値が不正です。';
    }
    if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{5,20}+\z/i', $_POST['password'])) {
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } elseif(isset($_POST['email']) || isset($_POST['password'])){
      echo "パスワードとメールアドレスを入力してください<br />前のページへ戻る";
      $count = 1;
    } else {
      echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ5文字以上で設定してください。\n前のページへ戻る';
      $count = 1;
      return false;
    }
    ?>
    </a>
    <a href="login.php">
    <?php
     session_start();
    if(isset($email)){
      if(isset($password)){
        $db_emails = "SELECT email FROM users";
        // query()で初めてDB検索が実行
        foreach ($dbh->query($db_emails, PDO::FETCH_BOTH) as $value) {
          if($value["email"] == $email){
            $count = 1;
            echo 'そのメールアドレスは既に登録されています<br />ログイン画面へ';
          }
        }
        if($count == 0){header('Location: http://localhost/mainpage.php');
          $insert = "INSERT INTO users (
          email, password) VALUES (:email,:password
        )";
        $stmt = $dbh->prepare($insert);
        $params = array(':email' => $email, ':password' => $password);
        $stmt->execute($params);
        // ログインの処理
        session_regenerate_id(true);
        $_SESSION['EMAIL'] = $email;
        exit;
        }
      }
    }
  ?>
  </a>
  </p>
  <?php
include dirname(__FILE__) . "/footer.php"
?>