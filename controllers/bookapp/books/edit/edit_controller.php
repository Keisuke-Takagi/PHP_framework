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
    $this->redirect_book_page();
    }
    return $e;
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
    $model_instance->setPostEdit($this->postData('edit'));
    $index_post_val = $model_instance->getPostEdit();
    $model_instance->setId($this->postData('id'));
    $model_instance->setTitle($this->postData('title'));
    $model_instance->setDescription($this->postData('description'));
    $model_error_num = $model_instance->editValidation($index_post_val);
    var_dump($index_post_val);
    if($index_post_val != ""){
      $book_array = explode("/", $index_post_val);
      $model_instance->setId($book_array[0]);
      $model_instance->setTitle($book_array[1]);
      $model_instance->setDescription($book_array[2]);
    }
    if($index_post_val == ""){
      $model_error_num = $this->update($model_instance, $model_error_num);
    }

  }

  if($_SERVER["REQUEST_METHOD"] != "POST"){
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