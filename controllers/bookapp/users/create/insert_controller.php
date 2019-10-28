<?php
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");


class Insertcontroller extends Applicationcontroller {
  public function content_print(){
    $content = "
                  <title>新規登録情報エラー</title>
                  </head>
                  <body>
                  <body>
                    <header id='header'>
                      <div class='app-icons'>
                        <nav class='navbar navbar-default'>
                          <div class='container-fluid'>
                            <div class='navbar-header'>
                              <a class='navbar-brand' href='../../../bookapp/users/index/registration'>READ-BOOK-RECORDER</a>
                              <div class='login-icon'>
                                <i class='fa fa-user' id='user-login-icon'  aria-hidden='true'></i>
                                <a href='../../../bookapp/users/login/login'>ログイン</a>
                              </div>
                            </div>
                          </div>
                        </nav>
                      </div>
                    </header>
                    <div class='main'>
                    <p>
                    <a href='../../../bookapp/users/index/registration' class='error'>";
      return [
        "content" => "{$content}"
      ];
  }
  public function second_content_print(){
    $content2 = "</a>
                <a href='login.php'>";
    return [
      "content2" => "{$content2}"
    ];
  }


  public function create($table_name, $action_name, $page_name, $template){
    $controller_name = get_class();
    echo $controller_name;
    if (!isset($_SESSION)) {
      session_start();
      }
      echo '<h1>insertのview</h1>';
      echo  '<h2><br>これemail'. $_POST['email'] . '</h2>';
      // ------------------------------------------------------------モデルコントローラー
      $model_class = $this->model_require($table_name, $action_name, $page_name);
      // モデルインスタンス作成

      $model_instance = new $model_class;

      if(isset($_POST['email']) || isset($_POST['title'])){
        // セッターゲッターを使ってエラー表示に変換
        $a = $model_instance->post_setter($_POST['email'],$_POST['password']);
        $post_checked = $model_instance->post_getter();
      }
        $count = 0;
        require_once(dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\views\\database.php");
        echo "<br>" . dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\views\\database.php";
        $database = new Database();
        $dbh = $database->open();
        // $dbh =new PDO("mysql:host=127.0.0.1; dbname=test; charset=utf8", 'root','');
        // if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        //   $count = 1;
        //   echo '入力された値が不正です。';
        // }else{
        //   $email = $_POST['email'];
        // }
        // if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{5,20}+\z/i', $_POST['password'])) {
        //   $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // } else {
        //   echo 'パスワードは半角英数字をそれぞれ1文字以上含んだ5文字以上で設定してください。<br >前のページへ戻る';
        //   $count = 1;
        //   return false;
        // }
        // </a>
        // <a href="login.php">
        // ここから
        // if(isset($email)){
        //   if(isset($password)){
          // アクションに対応するモデルメソッドが存在するか確認し、あればモデルアクションの実行
          $model_method_exec = $this->model_method_exist($model_class, $action_name);
          // この下はmodel_method関数内で
          if(!empty($model_method_exec)){
            // modelアクションが存在するとき
            $model_result = $this->model_exec($model_class, $action_name);
            // echo 'model_result<br>' . $model_result;
            if(is_array($model_result) != "Arraybool(true)" && $model_result == "true" || $model_result == NULL){
              // ここのtrueは   「Modelのバリデーションに成功したという意味」
              $email = $_POST['email'];
              $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
              $insert = "INSERT INTO users (
                email, password) VALUES (:email,:password
              )";
              $stmt = $dbh->prepare($insert);
              $params = array(':email' => $email, ':password' => $password);

              $stmt->execute($params);
              // return '<br><h2>登録完了</h2><br>';
              // 配列に入れていく処理

            // -----------------view
              $view_class = $this->view_require($table_name, $action_name, $page_name);
              
              $array = $this->array_conversion($controller_name);
              // var_dump($array);
              $display_data = $v->display_print($template, $array, $model_result);
              return $display_data;
              }else{
                // Modelのバリデーションに失敗  「modelからエラーが来ているときはこっち」
                $view_class = $this->view_require($table_name, $action_name, $page_name);
                $v = new $view_class;
                $array = $this->array_conversion($controller_name);
                $display_data = $v->error_print($template, $array, $view_class,$model_result);
                return $display_data;
              }
            // $view_class = $this->view_require($table_name, $action_name, $page_name);
            // $v = new $view_class;
            // $v->header_print($template, $headerData);
          }else{
            $controller_result = '<br><h3>modelのアクションが定義されていません</h3>';
            return $controller_result;
          }
          // モデルアクション実行処理
          // if($count == 1){
          //   // echo '<a href="../login/login">そのメールアドレスは既に登録されています<br />ログイン画面へ</a>';
          //   $model_result = $model_instance->$action_name("false");
          // }
          // // この処理をモデルに移す
          //   $db_emails = "SELECT email FROM users";
          //   // query()で初めてDB検索が実行
          //   // foreach ($dbh->query($db_emails, PDO::FETCH_BOTH) as $value) {
          //   //   if($value["email"] == $_POST['email']){
          //   //     $count = 1;
          //   //   }
          //   // }
          //   if($count == 0){
          //     $email = $_POST['email'];
          //     $password = $_POST['password'];
          //     // header('Location: http://localhost/bookapp/books/index/mainpage');
          //     $insert = "INSERT INTO users (
          //     email, password) VALUES (:email,:password
          //   )";
          //   $stmt = $dbh->prepare($insert);
          //   $params = array(':email' => $email, ':password' => $password);
          //   // 登録処理コメントアウト中
          //   // $stmt->execute($params);
          //   echo '<br>';
          //   var_dump($email);
          //   var_dump($password);
          //   // ログインの処理
          //   session_regenerate_id(true);
          //   echo '<br> SESSION';
          //   $_SESSION['EMAIL'] = $email;
          //   echo $email;
            // return "";
            // echo "<br>アクション取得" . __FUNCTION__;
            // $dir = explode("\\", __DIR__);
            // $arr = array_slice($dir, -2, -1);
            // // echo '<br>table_nameこれ'  .  $arr[0];
            // echo "<br>" . dirname(dirname(dirname(dirname(__DIR__)))) . "\\models\\bookapp\\users\\user.php";
            // $model_result = $model_instance->$action_name("");



            // $controller_name = get_class();
            // // コントローラインスタンス作成
            // $array = $this->array_conversion($controller_name);
            // return $array;
            // viewの呼び出し

            // return $array;
            exit;
            }
}

?>