<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");



class Editview extends Baseview{
  public function php_print(){

  }
  public function php_eroor_print(){
    
  }
}
//   <title>登録情報編集</title>
// </head>
// <body>
// <body>
//   <header id="header">
//     <div class="app-icons">
//       <nav class="navbar navbar-default">
//         <div class="container-fluid">
//           <div class="navbar-header">
//             <a class="navbar-brand" href="registration.php">READ-BOOK-RECORDER</a>
//             <div class="login-icon">
//               <i class="fa fa-user" id="user-login-icon"  aria-hidden="true"></i>
//               <a href="../../../bookapp/users/session/logout">ログアウト</a>
//               <a href="mainpage.php">メインページへ</a>
//             </div>
//           </div>
//         </div>
//       </nav>
//     </div>
//   </header>
//   <?php
//   if (!isset($_SESSION)) {
//     session_start();
//   }
//   if(isset($_SESSION['EMAIL']) &&  $_SESSION['COUNT'] > 0){
//     try {
//       echo $_SESSION['COUNT'];

//       require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\database.php");
//       $database = new Database();
//       $dbh = $database->open();
//       $stmt = $dbh->prepare('select * from books where id = ?');
//       $stmt->execute([$_POST[$_SESSION['COUNT']]]);
//       $row = $stmt->fetch(PDO::FETCH_ASSOC);
//       var_dump($row);
//       $_SESSION['BOOK_ID'] = $row['id'];
//     } catch (Exception $e) {
//       echo 'エラーが発生しました。:' . $e->getMessage();
//     }
//   }else{
//   }
  
  // <div class="main">
  //   <h1>本登録情報編集</h1>
  //     <form action="../../books/update/update" method="post" class=edit-book-form>
  //     <td>
  //       <div class="book-edit-box__title">
  //           <label>本のタイトル</label>
  // //           <input type="text" name="title"" class="form-input" value="
  //            print_r($row['title']); 
  //             ">
  //       </div>
  //       <div class="book-edit-box__description">
  //           <label>感想・要約</label>
  //           <textarea name="description" cols="20" rows="10" class="form_book_description"> 
    //             print_r($row['description']); 
    // </textarea>
  //       </div>
  //     </td>
  //     <button type="submit" class="btn btn-success btn-lg">編集を反映する</button>
  //   </form>
  // </div>
  

?>