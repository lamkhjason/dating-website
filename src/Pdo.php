<?php
  $host = 'localhost'; // Hostname
  $dbname = 'dating_website_db'; // Database name
  $dbUsername = 'root'; // Username
  $dbPassword = ''; // Password
  
  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['SCRIPT_NAME'] === "/dating-website/src/Pdo.php") {
      echo "Connected successfully";
    }
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  } 
?>