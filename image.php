<?php
// require_once 'functions.php';
// $pdo = connectDB();
// $sql = 'SELECT * FROM images WHERE image_id = :image_id LIMIT 1';
// $stmt = $pdo->prepare($sql);
// $stmt->bindValue(':image_id', (int)$_GET['id'], PDO::PARAM_INT);
// $stmt->execute();
// $image = $stmt->fetch();
echo 'ああああああああああああああああああああああああああ';
// header('Content-type: ' .'image/jpeg');
require_once("database.php");
$database = new Database();
$dbh = $database->open();
$sql = 'select * from images where book_id = ? limit 2';
$stmt2 = $dbh->prepare($sql);
$book_id = intval($_GET["id"]);
$book_id = 1;
$stmt2->execute(array($book_id));
$rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $image) {
  # code...
// header('Content-type: ' . $image['image_type']);
echo $image_name = $image['image_name'];
echo $image["raw_data"];
// $type_img = explode('.', $image_name);
// print $image['raw_data'];
// print $image;
}

unset($dbh);
exit();
?>