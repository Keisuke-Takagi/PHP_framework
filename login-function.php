<?php
include dirname(__FILE__) . "/head.php"
?>
  <title>ログインエラー</title>
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
    <?php
      if (!isset($_SESSION)) {
        session_start();
        }
//POSTのvalidate
if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  echo '入力されたアドレス値が不正です。';
  return false;
}
//DB内でPOSTされたメールアドレスを取り出し検索
try {
  $pdo = new PDO("mysql:host=127.0.0.1; dbname=test; charset=utf8", 'root', '');
  // prepareしたPDOstatmentを実行（execute）する
  $stmt = $pdo->prepare('select * from users where email = ?');
  $stmt->execute([$_POST['email']]);
  // selectされたPDOstatmentをfetchを使ってレコードの情報を配列として取得する
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  var_dump($row);
  var_dump($_POST['email']);
} catch (\Exception $e) {
  echo $e->getMessage() . PHP_EOL;
} catch (\Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}
// 入力されたアドレスが存在するか確認⇒⇒$stmtを実行した結果nullだとtrueに入るため
if (!isset($row['email'])) {
  echo 'メールアドレス又はパスワードが間違っています。';
  return false;
}
?>
<a href="login.php">
<?php
//パスワード確認後sessionにメールアドレスを渡す
if (password_verify($_POST['password'], $row['password'])) {header('Location: http://localhost/mainpage.php');
  session_regenerate_id(true); //session_idを新しく生成し、置き換える
  $_SESSION['EMAIL'] = $row['email'];
  exit;
} else {
  echo 'パスワードが間違っています。';
  return false;
}
?>
</a>
<?php
include dirname(__FILE__) . "/footer.php"
?>