<?php
include dirname(__FILE__) . "/head.php";
require_once("database.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $database = new Database();
$dbh = $database->open();
$array = $_FILES["file_upload"];
var_dump($array);
$image_name = $array["name"];
$image_type = $array["type"];
$image_size = $array["size"];
$tmp_name = $array["tmp_name"];
$raw_data = file_get_contents($tmp_name);
$stmt = $dbh->prepare('INSERT INTO `images`(`image_name`, `image_type`, `image_size`,`tmp_name`, `raw_data` ) 
VALUES (:image_name, :image_type, :image_size, :tmp_name, :raw_data)');
$array = array(':image_name' => $image_name, 'image_type' => $image_type, 'image_size' => $image_size, 'tmp_name' => $tmp_name, 'raw_data' => $raw_data);
// $stmt->execute($array);
if ($stmt->execute($array)) {
  echo 'あああああ成功';
}else {
  echo '失敗';
}



$stmt = $dbh->prepare('select * from images where tmp_name = ? ');

if($stmt->execute([$tmp_name])){
  $db_imgs = $stmt->fetch(PDO::FETCH_ASSOC);
  $image_name = $db_imgs["image_name"];
  $image_type = $db_imgs["image_type"];
  $image_size = $db_imgs["image_size"];
  $tmp_name = $db_imgs["tmp_name"];
  $raw_data = $db_imgs["raw_data"];
  foreach ($db_imgs as $k => $v) {
    echo '<br>' . $k;

  }
  echo $image_name .'あああああああああ'. $_FILES["file_upload"]["tmp_name"];
  
  move_uploaded_file($_FILES["file_upload"]["tmp_name"], "C:\\xampp\\htdocs\\bookapp\\images\\".$image_name);
}
}
var_dump($image_name);
?>
<title>読んだ本を登録する</title>
<div class="login-icon">
  <i class="fa fa-user" id="user-login-icon"  aria-hidden="true"></i>
  <a href="../../users/logout/logout">ログアウト</a>
</div>
</header>
<body>
    <div class='ontents_main'>
    <h1> 読んだ本登録フォーム</h1>
    <form action='http://localhost/up_img.php' method='post'  enctype="multipart/form-data"  class='new-user-form'>
      <input name="file_upload" type="file"> 
      <img src="<?php if(isset($image_name)){echo "bookapp/images/".$image_name;}?>">
      <td>
        <tr>
          <p>本のタイトル</p>
          <input type='text' name='title' class='form-input'>
        </tr>
        <tr>
          <p>感想・要約</p>
          <textarea name='description' cols='20' rows='10' class='form_book_description'></textarea>
        </tr>
      </td>
      <button type='submit' class='btn btn-success btn-lg'>本の登録</button>
    </form>
    </div>
    <a href="http://localhost/desp_img.php">画像表示</a>
</body>
