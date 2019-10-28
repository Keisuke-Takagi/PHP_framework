<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");

class Destroyview extends Baseview{
  public function php_print(){
    return '<p>ああああああああああああああ</p>';
  }
  public function php_error_print(){

  }
}

// <title>リスト削除</title>
// </head>
// <body>
// <header id="header">
//     <div class="app-icons">
//       <nav class="navbar navbar-default">
//         <div class="container-fluid">
//           <div class="navbar-header">
//             <a class="navbar-brand" href="registration.php">READ-BOOK-RECORDER</a>
//             <div class="login-icon">
//               <i class="fa fa-user" id="user-login-icon"  aria-hidden="true"></i>
//               <a href='../../../bookapp/users/logout/logout'>ログアウト</a>
//               <a href="mainpage.php">メインページへ</a>
//             </div>
//           </div>
//         </div>
//       </nav>
//     </div>
//   </header>
//   <div class="main">

  // if (!isset($_SESSION)) {
  // session_start();
  // }
  // if(isset($_SESSION['EMAIL']) && isset($_SESSION['COUNT'])){
  //   // header('Location: http://localhost/bookapp/books/index/mainpage');
  //   try {
  //     var_dump([$_POST[$_SESSION['COUNT']]]);
  //     // require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\database.php");
  //     $database = new Database();
  //     $dbh = $database->open();
  //     $stmt = $dbh->prepare('select * from books where id = ?');
  //     $stmt->execute([$_POST[$_SESSION['COUNT']]]);
  //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
  //     $delete_id = $row['id'];
  //     echo $delete_id;
  //     $stmt2 = $dbh->prepare('delete from books where id = ?');
  //     $stmt2->execute([$delete_id]);
  //     echo '<p>削除完了 </p>
  //           <br />
  //           <a href="../../../bookapp/books/index/mainpage">メインページへ戻る</a>';
  //   }catch (Exception $e) {
  //     echo 'エラーが発生しました。:' . $e->getMessage();
  //   }
  // }else{
  //   // header('Location: http://localhost/bookapp/users/index/registraton');
  // }
//   </div>
// </body>
// include dirname(__FILE__) . "/footer.php"
?>

