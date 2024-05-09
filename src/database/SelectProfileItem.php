<!-- 
  ファイル名： SelectProfileItem.php
  コード内容： プロフィール（編集）画面（DBの前処理）
-->
<?php
include_once("Pdo.php");
include_once("../components/CheckValue.php");

// 自分と他のユーザのプロフィールを判別する
if (isset($_GET["targetUserId"])) {
  if ($_GET["targetUserId"] == getUserIdSession()) {
    header("Location: Profile.php");
    exit();
  } else {
    $displayUserId = $_GET["targetUserId"];
  }
} else {
  $displayUserId = getUserIdSession();
}

try {
  // 表示するユーザのプロフィールを取得
  $profileSql = 
    "SELECT u.user_id, u.username, u.gender, u.age, u.blood_type,
    u.location, u.interests, u.description, pp.picture_contents, pp.picture_type
    FROM Users u LEFT JOIN Profile_Pictures pp 
    ON u.user_id = pp.user_id WHERE u.user_id = ?";
  $stmt = $conn->prepare($profileSql);
  $stmt->bindValue(1, $displayUserId);
  $stmt->execute();
  
  $profileItem = $stmt->fetch(PDO::FETCH_ASSOC);
  
} catch (PDOException $e) {
  setErrorMessage("プロフィール項目取得失敗：".$e->getMessage());
}

// プロフィール項目が入力されているかの確認
$username = checkProfileItem($profileItem['username']);
$gender = checkProfileItem($profileItem['gender']);
$age = checkProfileItem($profileItem['age']);
$bloodType = checkProfileItem($profileItem['blood_type']);
$location = checkProfileItem($profileItem['location']);
$interests = checkProfileItem($profileItem['interests']);
$description = checkProfileItem($profileItem['description']);

$pictureContents = checkProfileItem($profileItem['picture_contents']);
$pictureType = checkProfileItem($profileItem['picture_type']);