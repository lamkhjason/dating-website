<?php
// ファイル名： Pdo.php
// コード内容： データベース接続

$host = 'localhost'; // ホスト
$dbname = 'dating_website_db'; // 各自のデータベース名
$dbUsername = 'root'; // データベースの利用者名
$dbPassword = ''; // パスワード

try {
  $conn = new PDO(
    "mysql:host=$host;dbname=$dbname", 
    $dbUsername, 
    $dbPassword
  );
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // "/dating-website/src"を各自のファイル名に変更する
  if ($_SERVER["SCRIPT_NAME"] === "/dating-website/src/database/Pdo.php") {
    echo "データベース接続成功！";
  }
  
} catch (PDOException $e) {
  echo "データベース接続失敗：" . $e->getMessage();
} 