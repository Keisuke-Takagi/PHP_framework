<?php
$file = 'C:\xampp\htdocs\bookapp\view_require.php';
if (is_readable($file)) {	// ファイルが読めれば
  $fp = fopen($file, "rb");
  if ($fp) {	// オープンできれば
      while (($line=fgets($fp)) !== false) {
        echo $line;
      }
      fclose($fp);
  } else {
      echo"開けません";
  }
} else {
  echo "読めません";
}
echo 'aaaaa0';
?>