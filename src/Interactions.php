<?php
session_start();
?>
<?php
include_once("Pdo.php");
include_once("CommmonTools.php");
include_once("LoginStatus.php");
// $loginID = $_SESSION['user_id'];
// $LoginID=1;//現在のログインしてるユーザID(仮)
// $dsn='mysql:host=localhost;dbname=matching;charset=utf8';
// $username = 'root';
// $dbh =new pdo($dsn,$username);
// $options = [
//     PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
// ];
try{
  $stmt = $dbh->prepare("SELECT u.user_id, u.username, u.gender, u.age, p.picture_contents, p.picture_type
  FROM users u
  LEFT OUTER JOIN interactions i ON u.user_id = i.target_user_id AND i.user_id = :LoginID
  LEFT OUTER JOIN Profile_Pictures p ON u.user_id = p.user_id
  WHERE i.user_id IS NULL AND u.user_id != :LoginID;");

  $stmt->bindParam(':LoginID',$LoginID,PDO::PARAM_INT);
  $stmt->execute();
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p>Failed : " . $e->getMessage()."</p>";
    exit();
}
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['like'])){
      $targetUserId = $_POST['targetUserId'];
    }
    try{
      $interaction_type = 'いいね'; 

      $insert = $dbh->prepare("INSERT INTO Interactions (user_id, target_user_id, interaction_type) VALUES (:user_id, :target_user_id, :interaction_type)");
      $insert->bindParam(':user_id', $LoginID, PDO::PARAM_INT);
      $insert->bindParam(':target_user_id', $targetUserId, PDO::PARAM_INT);
      $insert->bindParam(':interaction_type', $interaction_type, PDO::PARAM_STR);
      $insert->execute();
      
      $select = $dbh->prepare("SELECT * FROM interactions 
      WHERE user_id = :targetUserId 
      AND target_user_id = :LoginID");
      $select->bindParam(':targetUserId', $targetUserId, PDO::PARAM_INT);
      $select->bindParam(':LoginID', $LoginID, PDO::PARAM_INT);
        
      $select->execute();
        
      $result = $select->fetch(PDO::FETCH_ASSOC); 

      if ($result) {
        header("Location: Congratulations.php");
      } else {
        header("Location: " . $_SERVER['PHP_SELF']);
      }
    } catch (PDOException $e) {
      echo "エラー: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>いいね画面</title>
</head>
<body>  
<div class="row row-cols-1 row-cols-md-3 g-4">
<?php foreach ($users as $user): ?>
<div class="col">
    <div class="card">
    <img src="data:image/<?= $user['picture_type'] ?>;base64,<?= base64_encode($user['picture_contents']) ?>" class="card-img-top">
      <div class="card-body">
        <h5 class="card-title"><?=$user['username']?></h5>
        <p class="card-text1"><?=$user['gender']?></p>
        <p class="card-text2"><?=$user['age']?></p>
        <form action="" method="POST">
        <input type="hidden" name="targetUserId" value="<?=$user['user_id']?>">
        <button type="submit" name="like" class="btn good-btn-primary">いいね</button>
        </form>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</body>
</html>