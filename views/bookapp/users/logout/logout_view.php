<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/users/connect_view.php");
require_once(dirname(dirname(dirname(__FILE__))) . "/index/head.php");
?>
  <title>ログアウト</title>
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
              <a href="../index/registration">新規登録</a>
              <a href="../login/login">ログイン</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <div class="main">
  <p>
  <?php
  if (!isset($_SESSION)) {
    session_start();
    }
  // ログイン状態にあるとき
  if(isset($_SESSION['EMAIL'])){
    $_SESSION = array();
    session_destroy();
    echo "ログアウトしました";
  }else{header('Location: http://localhost/bookapp/users/index/registration#');
    exit;
  };
  ?>
  </p>
  </div>
  
  <?php
require_once(dirname(dirname(dirname(__FILE__))) . "/index/footer.php");
?>