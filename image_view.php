<?php
require_once("desp_img.php");
class GetImg extends ImageTemplate{
  public function get_img(){
    $this->setArray();
    $array = getArray();
    $image_name = $array["image_name"];
    $image_type = $array["image_type"];
    $image_size = $array["image_size"];
    $tmp_name = $array["tmp_name"];
    $content = file_get_contents($tmp_name);
    return $content;
  }

}
?>