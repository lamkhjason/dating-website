<?php
// ファイル名： Pdo.php
// コード内容： データベース接続

$host = 'localhost'; // ホスト
$dbname = 'dating_website_db'; // データベース名
$dbUsername = 'root'; // データベースの利用者名
$dbPassword = ''; // パスワード

try {
  $conn = new PDO(
    "mysql:host=$host;dbname=$dbname", 
    $dbUsername, 
    $dbPassword
  );
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "データベース接続成功！";
  
} catch (PDOException $e) {
  echo "データベース接続失敗：" . $e->getMessage();
} 