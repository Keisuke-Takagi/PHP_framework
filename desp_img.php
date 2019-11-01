<?php
// $title = $_POST["title"];
// var_dump($title);
// $array = $_FILES["file_upload"];
// var_dump($array);
// foreach ($array as $value) {
//   # code...


//   echo '<br>' . $value;
// }

require_once("database.php");
require_once("image_view.php");

// $database = new Database();
// $dbh = $database->open();
// $stmt = $dbh->prepare('select * from images where id = ? ');
// $stmt->execute(1);
// $array = $stmt->fetch(PDO::FETCH_ASSOC);

class ImageTemplate {
  public $array;
  public function get_img(){
    $this->setArray();
    $array = $this->getArray();
    $image_name = $array["image_name"];
    $image_type = $array["image_type"];
    $image_size = $array["image_size"];
    $tmp_name = "C:\\xampp\\tmp\\test.jpg";
    echo '<br>';
    $content = file_get_contents("C:\\xampp\\tmp\\test.jpg");
    return [
      "content" => $content,
      "image_type" => $image_type,
      "path" => $tmp_name
    ];
  }
  public function return_img(){
    $content_img = $this->get_img();
    return $content_img["content"];
  }
  public function  return_content_type(){
    $content_img = $this->get_img();
    return $content_img["image_type"];
  }

  public function setArray(){
    
    $database = new Database();
    $dbh = $database->open();
    $stmt = $dbh->prepare('select * from images where id = ? ');
    $stmt->execute(["1"]);
    $array = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->array = $array;
    // var_dump($array);
  }

  public function getArray(){
    return $this->array;
  }
}

$image_instance = new ImageTemplate;
// $image_name = $array["name"];
// $image_type = $array["type"];
// $image_size = $array["size"];
// $tmp_name = $array["tmp_name"];
// $content = file_get_contents($tmp_name);
$image_content = $image_instance->return_img();
$content_type = $image_instance->return_content_type();
$path = $image_instance->get_img();
$path = $path["path"];
var_dump($path);
// header("Content-Type: {$content_type}");

?>


<h1>desp_img</h1>

<img src="<?php echo $path; ?>" alt="">
