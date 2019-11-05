<?php
// namespace Bookapp\books\edit;
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");
class Editcontroller extends Applicationcontroller {
  public function redirect_book_page(){
    header('Location: http://localhost/bookapp/books/index/mainpage');
  }
  public function update($model_instance){
    $e = 2;
    $id = $model_instance->getId();
    $title = $model_instance->getTitle();
    $description = $model_instance->getDescription();
    $id = intval($id);
    if($title != ""){
      require_once(dirname(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php");
      $database = new Database();
      $dbh = $database->open();
      $stmt = $dbh->prepare('UPDATE books SET  title = :title, description = :description WHERE id = :id');
      $stmt->bindValue(':id',$id, PDO::PARAM_INT);
      $stmt->bindValue(':title',$title, PDO::PARAM_STR);
      $stmt->bindValue(':description', $description, PDO::PARAM_STR);
      $stmt->execute();
      $e = "";
      // $this->redirect_book_page();
    }
    return $e;
  }

  public function set_model($model_instance){
    $model_error_num = "";
    $model_instance->setPostEdit($this->postData('edit'));
    $index_post_val = $model_instance->getPostEdit();
    $model_instance->setId($this->postData('id'));
    $model_instance->setTitle($this->postData('title'));
    $model_instance->setDescription($this->postData('description'));
    if($index_post_val != ""){
      $book_array = explode("/", $index_post_val);
      $model_instance->setId($book_array[0]);
      $model_instance->setTitle($book_array[1]);
      $model_instance->setDescription($book_array[2]);
    }
    return $index_post_val;
  }
  
  public function edit($table_name, $action_name, $page_name, $template){

    $template_path = "";
    $model_error_num = "";
    $post_info = "";
    $title = "";
    $template_path = $template;
    $model_class = $this->model_require($table_name, $action_name, $page_name);
    $model_instance = new $model_class;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
      header('Content-type: image/jpeg');
      $index_post_val = $this->set_model($model_instance);
      var_dump($model_error_num);
      if(isset($_FILES["upimg"])){
        require_once(dirname(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php");
        $database = new Database();
        $dbh = $database->open();
        
        // foreach ($_FILES["upimg"] as $k => $v) {
        //   echo $k."=>".$v ."<br>";
        // }
        $image_name = $_FILES["upimg"]["name"];
        	
        $filename = mb_convert_encoding($filename, "cp932", "utf8");
        $image_name = date("Y/m/d/His") . $image_name;
        $image_type = $_FILES["upimg"]["type"];
        $image_size = $_FILES["upimg"]["size"];
        $image_size = intval($image_size);
        $tmp_name = $_FILES["upimg"]["tmp_name"];
        $raw_data = file_get_contents($tmp_name);
        echo $raw_data;
        $book_id = $model_instance->getId();
        $book_id = intval($book_id);
        $select = 'select * from images where book_id = ? ';
        $stmt = $dbh->prepare($select);
        $stmt->execute(array($book_id));
        $row_img = $stmt->fetch(PDO::FETCH_ASSOC);
        var_dump($raw_data);
        if($row_img != ""){
          echo "画像ありPDOで編集する";
          $stmt = $dbh->prepare('UPDATE images SET image_name = :image_name, image_type = :image_type, image_size = :image_size, raw_data = :raw_data WHERE book_id = :book_id');
          $stmt->bindValue(':image_name', $image_name, PDO::PARAM_STR);
          $stmt->bindValue(':image_type', $image_type, PDO::PARAM_STR);
          $stmt->bindValue(':image_size', $image_size, PDO::PARAM_INT);
          $stmt->bindValue(':raw_data', $raw_data, PDO::PARAM_STR);
          $stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
          $stmt->execute();
          
        }
        if($row_img === false){
          $insert = "INSERT INTO images (
            image_name, image_type, image_size, raw_data, book_id) VALUES (:image_name, :image_type, :image_size, :raw_data, :book_id
          )";
          $stmt = $dbh->prepare($insert);
          $params = array(':image_name' => $image_name, ':image_type' => $image_type, ':image_size' => $image_size, ':raw_data' => $raw_data, ':book_id' => $book_id);
          $stmt->execute($params);
        }

      }
    if($index_post_val == "" && $model_error_num == ""){
      $model_error_num = $this->update($model_instance, $model_error_num);
    }
  }

  if($_SERVER["REQUEST_METHOD"] != "POST"){
    // $this->redirect_book_page();
  }
  if($model_error_num != ""){
    $template_path = $this->get_error_template($template, $model_error_num, $model_error_num);
  }
  return [
    "model_instance" => $model_instance,
    "template_path" => $template_path,
  ];
  }
}

?>