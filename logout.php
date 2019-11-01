<?php
include dirname(__FILE__) . "/head.php"
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
              <a href="registration.php">新規登録</a>
              <a href="login.php">ログイン</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
  </header>
  <div class="main">
  <p>
  <?php
  session_start();
  // ログイン状態にあるとき
  if(isset($_SESSION['EMAIL'])){
    $_SESSION = array();
    session_destroy();
    echo "ログアウトしました";
  }else{header('Location: http://localhost/registration.php');
    exit;
  };
  ?>
  </p>
  </div>
  
  <?php
include dirname(__FILE__) . "/footer.php"
?>