<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/users/connect_view.php");
// require_once(dirname(dirname(dirname(__DIR__)))."/BaseView.php");

// class Insertview extends \Views\Baseview{
//   public function users() {
//     $users = [];
//     return $users;
//   }
// }



require_once(dirname(dirname(dirname(__FILE__))) . "/index/head.php");
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
  echo __FILE__;
  echo '<h1>insertのview</h1>';
  echo $_POST['email'];
    $count = 0;

    require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\database.php");
    echo "<br>" . dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
    $database = new Database();
    $dbh = $database->open();


    // $dbh =new PDO("mysql:host=127.0.0.1; dbname=test; charset=utf8", 'root','');
    
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
      echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ5文字以上で設定してください。<br >前のページへ戻る';
      $count = 1;
      return false;
    }
    ?>
    </a>
    <a href="login.php">
    <?php
    // ここから
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
        if($count == 0){header('Location: http://localhost/bookapp/books/index/mainpage');
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
  <!-- ここまで -->
  </a>
  </p>
  <?php
include (dirname(dirname(dirname(__FILE__))) . "/index/footer.php");
?>