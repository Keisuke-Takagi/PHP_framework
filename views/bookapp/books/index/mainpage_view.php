<?php
// namespace Bookapp\books\index;
// require_once(dirname(dirname(dirname(__DIR__)))."/BaseView.php");

// bookappとbooksは変数で定義して外部から持ってくる記述が後で必要
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");

// class Mainpageview extends \Views\Baseview{
//   public function users() {
//     $users = [];
//     return $users;
//   }
// }
// require_once(dirname(dirname(dirname(__FILE__))) . "/index/head.php");
class Mainpageview extends Baseview{
  public function php_print($tenplate, $model_results){
      $htmlStr = "";
      $num = 0;
      $viewModel = $model_results["model_instance"];
      $first_html = file_get_contents(dirname(dirname(dirname(dirname(__DIR__)))) . "\\template\bookapp\books\index\bookinfo_mainpage_template.html");
      $first_layout_path = dirname(dirname(dirname(dirname(__DIR__)))) . "\\template\bookapp\books\index\mainpage_template.html";
      $first_layout = file_get_contents($first_layout_path);
      $book_info = $viewModel->getAll();
      $book_count = $book_info["book_count"];
      $book_html = $book_info["book_html_array"];
      while($book_count > $num){
        $htmlStr .= $first_html;
        foreach ($viewModel->getKeys() as $key) {
          $htmlStr = str_replace("<<".$key .">>", $book_html[$key][$num], $htmlStr);
        }
        $num += 1;
      }

      $layout_path = (dirname(dirname(dirname(dirname(__DIR__))))."/template/bookapp/layout/index.html");
      $layout = file_get_contents($layout_path);

      $books_view_html = $viewModel->getBookHtmlArray();
 
      $htmlStr = str_replace("<<book_content>>", $htmlStr, $first_layout);
  
      $htmlStr = str_replace("<<contents>>", $htmlStr, $layout);

      print $htmlStr;

      // $num = 0;
      // echo  '<thead>
      //       <tr>
      //           <th id="table_title＿id" style="width: 13%;">本のID</th>
      //           <th id ="table_title__name" style="width: 24%">本のタイトル</th>
      //           <th id="table_title__description" style~"">本の説明</th>
      //           <th id="table_title__menu" style="width: 13%;">編集・削除</th>
      //         </tr>
      //       </thead>
      //       <tbody>';
      // while($num  < $_SESSION['COUNT']){
      //       // ここから表示機能
      // echo  '<tr>
      //         <td><p>';
      // echo  $num + 1;
      // echo  ' </p></td>
      //         <td><p>';
      // echo  $actionexec[$num]["title"];
      // echo  '  </p></td>
      //         <td><p>';
      // echo  $actionexec[$num]["description"];
      // echo  '</p></td>
      //         <td class="menu-flex-box" style="display: flex; flex-flow: row-reverse;">
      //         <div>
      //         <form action="http://localhost/bookapp/books/delete/destroy" method="post" class="new-user-form">
      //         <input type="hidden"name="';
      //         echo $_SESSION['COUNT'];
      //         echo '" class="btn btn-danger"value="';
      //         echo  $actionexec[$num]["id"];
      //         echo'">
      //         <input type="submit" class="btn btn-danger"style="margin-right:70px; width: 100px;" value="削除">
      //         </form></div>
      //         <div>
      //         <form action="http://localhost/bookapp/books/edit/edit" method="post" class="edit-book-form">
      //         <input type="hidden"name="';
      //         echo $_SESSION['COUNT'];
      //         echo '" class="btn btn-danger" style="margin: 2px 20px;"value="';
      //         echo $actionexec[$num]["id"];
      //         echo '">
      //         <input type="submit" class="btn btn-warning" style="margin-left:70px; width: 100px;" value="編集">
      //         </form></div></td>';
      // echo    '</tr>';
      // $num += 1;
  }
  // <div class="col-5 ml-3">
  //       <div class="card">
  //           <div class="table-responsive">
  //           <table class="table table-responsive table-bordered table-striped table-hover table-responsive" style="white-space: nowrap;">
  //                       <thead>
  //                               <tr>
  //                                   <th id="table_title＿id" style="width: 13%;">本のID</th>
  //                                   <th id="table_title__name" style="width: 24%">本のタイトル</th>
  //                                   <th id="table_title__description" style~""="">本の説明</th>
  //                                   <th id="table_title__menu" style="width: 13%;">編集・削除</th>
  //                               </tr>
  //                             </thead>
  //                             <tbody><tr>
  //                                       <td><p>1 </p></td>
  //                                       <td><p>タイトル  </p></td>
  //                                       <td><p>本の説明</p></td>
  //                                       <td class="menu-flex-box" style="display: flex; flex-flow: row-reverse;">
  //                                       <div>
  //                                       <form action="delete.php" method="post" class="new-user-form">
  //                                       <input type="hidden" name="7" class="btn btn-danger" value="4">
  //                                       <input type="submit" class="btn btn-danger" style="margin-right:70px; width: 100px;" value="削除">
  //                                       </form></div>
  //                                       <div>
  //                                       <form action="edit.php" method="post" class="edit-book-form">
  //                                       <input type="hidden" name="ああ" class="btn btn-danger" style="margin: 2px 20px;" value="いいい">
  //                                       <input type="submit" class="btn btn-warning" style="margin-left:70px; width: 100px;" value="編集">
  //                                       </form></div></td></tr>
  //               </tbody>
  //           </table>
  //         </div>

  //       </div>
  //   <div class="col-5 ml-3">
  //       <div class="card">
  //           <div class="table-responsive">
  //           <table class="table table-responsive table-bordered table-striped table-hover table-responsive" style="white-space: nowrap;">
  //                       <thead>
  //                               <tr>
  //                                   <th id="table_title＿id" style="width: 13%;">本のID</th>
  //                                   <th id="table_title__name" style="width: 24%">本のタイトル</th>
  //                                   <th id="table_title__description" style~""="">本の説明</th>
  //                                   <th id="table_title__menu" style="width: 13%;">編集・削除</th>
  //                               </tr>
  //                             </thead>
  //                             <tbody><tr>
  //                                       <td><p>1 </p></td>
  //                                       <td><p>タイトル  </p></td>
  //                                       <td><p>本の説明</p></td>
  //                                       <td class="menu-flex-box" style="display: flex; flex-flow: row-reverse;">
  //                                       <div>
  //                                       <form action="delete.php" method="post" class="new-user-form">
  //                                       <input type="hidden" name="7" class="btn btn-danger" value="4">
  //                                       <input type="submit" class="btn btn-danger" style="margin-right:70px; width: 100px;" value="削除">
  //                                       </form></div>
  //                                       <div>
  //                                       <form action="edit.php" method="post" class="edit-book-form">
  //                                       <input type="hidden" name="ああ" class="btn btn-danger" style="margin: 2px 20px;" value="いいい">
  //                                       <input type="submit" class="btn btn-warning" style="margin-left:70px; width: 100px;" value="編集">
  //                                       </form></div></td></tr>
  //               </tbody>
  //           </table>
  //         </div>

  //       </div>
  //   </div></div>
  public function php_error_print($actionexec){
    if(isset($_SESSION['COUNT']) && $_SESSION['COUNT'] >= 1){
      $num = 0;
      $return_html = "";
      $return_html .=  '<thead>
                        <tr>
                            <th id="table_title＿id" style="width: 13%;">本のID</th>
                            <th id ="table_title__name" style="width: 24%">本のタイトル</th>
                            <th id="table_title__description" style~"">本の説明</th>
                            <th id="table_title__menu" style="width: 13%;">編集・削除</th>
                          </tr>
                        </thead>
                        <tbody>';
      while($num  < $_SESSION['COUNT']){
            // ここから表示機能
      $return_html .=  '<tr>
                        <td><p>';
      $return_html .=  $num + 1;
      $return_html .=  ' </p></td>
                          <td><p>';
      $return_html .=  $actionexec[$num]["title"];
      $return_html .=  '  </p></td>
                        <td><p>';
      $return_html .=  $actionexec[$num]["description"];
      $return_html .=  '</p></td>
                        <td class="menu-flex-box" style="display: flex; flex-flow: row-reverse;">
                        <div>
                        <form action="http://localhost/bookapp/books/delete/destroy" method="post" class="new-user-form">
                        <input type="hidden"name="';
      $return_html .= $_SESSION['COUNT'];
      $return_html .= '" class="btn btn-danger"value="';
      $return_html .=  $actionexec[$num]["id"];
      $return_html .='">
                        <input type="submit" class="btn btn-danger"style="margin-right:70px; width: 100px;" value="削除">
                        </form></div>
                        <div>
                        <form action="http://localhost/bookapp/books/edit/edit" method="post" class="edit-book-form">
                        <input type="hidden"name="';
      $return_html .= $_SESSION['COUNT'];
      $return_html .= '" class="btn btn-danger" style="margin: 2px 20px;"value="';
      $return_html .= $actionexec[$num]["id"];
      $return_html .= '">
                        <input type="submit" class="btn btn-warning" style="margin-left:70px; width: 100px;" value="編集">
                        </form></div></td>';
      $return_html .=    '</tr>';
      $num += 1;
      }
    }else{
    }
    return $return_html;
  }
}

// <!-- <title>登録本一覧</title>
// </head>
// <body>
// <header id="header">
//     <div class="app-icons">
//       <nav class="navbar navbar-default">
//         <div class="container-fluid">
//           <div class="navbar-header">
//             <a class="navbar-brand" href="/bookapp/users/index/registration">READ-BOOK-RECORDER</a>
//             <div class="login-icon">
//               <i class="fa fa-user" id="user-login-icon"  aria-hidden="true"></i>
//               <a href="../../../bookapp/users/session/logout">ログアウト</a>
//             </div>
//           </div>
//         </div>
//       </nav>
//     </div>
//   </header>

// <body>
//   <div class="contents_main">
//     <h1 class="my-3 ml-3">読んだ本リスト</h1>
//     <a type="button" class="btn btn-success" style="margin: 10px 0 10px 0; height:50px;   line-height: 33px;" href="http://localhost/bookapp/books/new/registration">読んだ本を登録する</a> -->
//     <!-- <div class="col-5 ml-3">
//         <div class="card">
//             <div class="table-responsive">
//             <table class="table table-responsive table-bordered table-striped table-hover table-responsive" style="white-space: nowrap;"> -->
                        
                          // error_reporting(E_ALL);
                          // ini_set('display_errors', '1');
                          //   if (!isset($_SESSION)) {
                          //     session_start();
                          //     }
                          //     if(isset($_SESSION['EMAIL'])){
                          //     require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."\database.php");
                          //     // エラー箇所
                          //     $database = new Database();
                          //     $dbh = $database->open();
                              // $stmt = $dbh->prepare('select * from users where email = ? ');
                              // $stmt->execute([$_SESSION['EMAIL']]);
                              // $row = $stmt->fetch(PDO::FETCH_ASSOC);

                              // $user_id = $row['id'];
                              // $_SESSION['USER_ID'] = $user_id;
                              // $sql = 'select * from books where user_id = ? limit 100';
                              // $stmt2 = $dbh->prepare($sql);
                              // $stmt2->execute(array($user_id));
                              // $results = $stmt2->fetchAll(PDO::FETCH_ASSOC);



                          // このtableをクラスか
                              // echo '<br> これ$results<br> ';
                              // var_dump($results);
                              // $count = count($results);
                              // $_SESSION['COUNT'] = $count;



                              // if(isset($_SESSION['COUNT']) && $_SESSION['COUNT'] >= 1){
                              //   $num = 0;
                              //   echo  '<thead>
                              //   <tr>
                              //       <th id="table_title＿id" style="width: 13%;">本のID</th>
                              //       <th id ="table_title__name" style="width: 24%">本のタイトル</th>
                              //       <th id="table_title__description" style~"">本の説明</th>
                              //       <th id="table_title__menu" style="width: 13%;">編集・削除</th>
                              //     </tr>
                              //   </thead>
                              //   <tbody>';
                              //   while($num  < $_SESSION['COUNT']){
                              //         // ここから表示機能
                              //   echo  '<tr>
                              //           <td><p>';
                              //   echo  $num + 1;
                              //   echo  ' </p></td>
                              //           <td><p>';
                              //   echo  $actionexec[$num]["title"];
                              //   echo  '  </p></td>
                              //           <td><p>';
                              //   echo  $actionexec[$num]["description"];
                              //   echo  '</p></td>
                              //           <td class="menu-flex-box" style="display: flex; flex-flow: row-reverse;">
                              //           <div>
                              //           <form action="http://localhost/bookapp/books/delete/destroy" method="post" class="new-user-form">
                              //           <input type="hidden"name="';
                              //           echo $_SESSION['COUNT'];
                              //           echo '" class="btn btn-danger"value="';
                              //           echo  $results[$num]["id"];
                              //           echo'">
                              //           <input type="submit" class="btn btn-danger"style="margin-right:70px; width: 100px;" value="削除">
                              //           </form></div>
                              //           <div>
                              //           <form action="http://localhost/bookapp/books/edit/edit" method="post" class="edit-book-form">
                              //           <input type="hidden"name="';
                              //           echo $_SESSION['COUNT'];
                              //           echo '" class="btn btn-danger" style="margin: 2px 20px;"value="';
                              //           echo $results[$num]["id"];
                              //           echo '">
                              //           <input type="submit" class="btn btn-warning" style="margin-left:70px; width: 100px;" value="編集">
                              //           </form></div></td>';
                                        
                              //   echo    '</tr>';
                              //   $num += 1;
                              //   }
                              // }else{
                              // }
                            // }else{
                            // }
                          ?>


<?php

// require_once(dirname(dirname(dirname(__FILE__)))  . "/index/footer.php");
?>