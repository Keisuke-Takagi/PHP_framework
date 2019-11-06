<?php
// namespace Bookapp\books\edit;
require_once(dirname(dirname(dirname(__FILE__))) . "\\application_controller.php");
class Editcontroller extends Applicationcontroller {
  public function redirect_book_page(){
    header('Location: http://localhost/bookapp/books/index/mainpage');
  }
  private function update($model_instance){
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
      $this->redirect_book_page();
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
  }
  // 指定された本に対応する画像の検索
  private function search_img_column($model_instance){
    if($_FILES["upimg"]["name"] != ""){
      // メインページからのPOSTキーがない（⇐一回目のページ表示でない）かつ$_FILESで値が取得できたとき
      require_once(dirname(dirname(dirname(dirname(__DIR__)))) . "\\views\\database.php");
      $database = new Database();
      $dbh = $database->open();

      // imagesの検索に必要な値の取得
      $book_id = $model_instance->getId();
      $book_id = intval($book_id);

      $select = 'select * from images where book_id = ? ';
      $stmt = $dbh->prepare($select);
      $ret = $stmt->execute(array($book_id));
      if(!$ret){
        print "error";
      }
      else{
        $row_img = $stmt->fetch(PDO::FETCH_ASSOC);
        // DBに保存する値の取得
        $image_name = $_FILES["upimg"]["name"];
        $image_name = date("Y/m/d/His") . $image_name;
        $image_type = $_FILES["upimg"]["type"];
        $image_size = $_FILES["upimg"]["size"];
        $image_size = intval($image_size);
        $tmp_name = $_FILES["upimg"]["tmp_name"];
        $raw_data = file_get_contents($tmp_name);
        $raw_data = base64_decode($raw_data);

        //  row_imgが本に対応する画像レコード
        if($row_img != ""){
          // 既にDBにimgレコードがある場合編集処理呼び出し
          $this->update_img($dbh, $image_name, $image_type, $image_size, $raw_data, $book_id);
        }else{
          // DBにimgレコードが存在しない場合作成処理呼び出し
          $this->create_img($dbh, $image_name, $image_type, $image_size, $raw_data, $book_id);
        }
      }
    }
  }

  // 「画像更新」
  private function update_img($dbh, $image_name, $image_type, $image_size, $raw_data, $book_id){
    $stmt = $dbh->prepare('UPDATE images SET image_name = :image_name, image_type = :image_type, image_size = :image_size, raw_data = :raw_data WHERE book_id = :book_id');
    $stmt->bindValue(':image_name', $image_name, PDO::PARAM_STR);
    $stmt->bindValue(':image_type', $image_type, PDO::PARAM_STR);
    $stmt->bindValue(':image_size', $image_size, PDO::PARAM_INT);
    $stmt->bindValue(':raw_data', $raw_data, PDO::PARAM_STR);
    $stmt->bindValue(':book_id', $book_id, PDO::PARAM_INT);
    $stmt->execute();
  }

  // 「画像作成」
  private function create_img($dbh, $image_name, $image_type, $image_size, $raw_data, $book_id){
    $insert = "INSERT INTO images (
      image_name, image_type, image_size, raw_data, book_id) VALUES (:image_name, :image_type, :image_size, :raw_data, :book_id
    )";
    $stmt = $dbh->prepare($insert);
    $params = array(':image_name' => $image_name, ':image_type' => $image_type, ':image_size' => $image_size, ':raw_data' => $raw_data, ':book_id' => $book_id);
    $stmt->execute($params);
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
        // 本に関するPOSTされた値をmodelに保存
        $this->set_model($model_instance);
        var_dump($model_error_num);
        
        // 更新の処理のためmainpageのPOSTキーがない、ファイルのPOST確認
        if(!isset($_POST["edit"])){
          if($_FILES["upimg"]["name"] != ""){
            $this->search_img_column($model_instance);
          }
        if($model_error_num == ""){
          $model_error_num = $this->update($model_instance, $model_error_num);
        }
      }
    }else{
      $this->redirect_book_page();
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