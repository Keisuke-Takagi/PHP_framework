<?php
require_once(dirname(dirname(dirname(dirname(__DIR__)))). "/views/bookapp/books/connect_view.php");
// require_once(dirname(dirname(dirname(__FILE__))) . "/index/head.php");

// <!-- <title>読んだ本を登録する</title>
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
//             </div>
//           </div>
//         </div>
//       </nav>
//     </div>
//   </header>
//   <p>

class Registrationview extends Baseview{
  public function php_print($template, $model_results){
    $htmlStr = file_get_contents($model_results["template_path"]);
    $layout_path = (dirname(dirname(dirname(dirname(__DIR__))))."/template/bookapp/layout/index.html");
    $layout = file_get_contents($layout_path);
    // $model_array = $viewModel->getAll();
    $viewModel = $model_results["model_instance"];
    foreach ($viewModel->getAll() as $k => $v) {
      $htmlStr = str_replace("<<".$k.">>", $v, $htmlStr);
    }
    $htmlStr = str_replace("<<contents>>", $htmlStr, $layout);
    print $htmlStr;
  }
  public function php_error_print($e){

  }
}
  // if(isset($_SESSION['EMAIL'])){
  //   echo "This is main page";
  // }else{header('Location: http://localhost/registration.php');}
?>
<!-- </p>
<body>
    <div class="contents_main">
    <h1> 読んだ本登録フォーム</h1>
    <form action="http://localhost/bookapp/books/create/insert" method="post" class="new-user-form">
      <td>
        <tr>
          <p>本のタイトル</p>
          <input type="text" name="title"" class="form-input">
        </tr>
        <tr>
          <p>感想・要約</p>
          <textarea name="description" cols="20" rows="10" class="form_book_description"></textarea>
        </tr>
      </td>
      <button type="submit" class="btn btn-success btn-lg">本の登録</button>
    </form>
    </div>
</body> --> 