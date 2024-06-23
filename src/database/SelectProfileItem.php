<?php
// ファイル名： SelectProfileItem.php
// コード内容： プロフィール（編集）画面（DBの前処理）

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
    "SELECT u.username, u.gender, u.age, u.blood_type, u.location, u.interests, 
    u.description, u.height, u.weight, u.education, u.occupation, u.smoking_habits,
    u.drinking_habits FROM Users u WHERE u.user_id = ?";
  $stmt = $conn->prepare($profileSql);
  $stmt->bindValue(1, $displayUserId);
  $stmt->execute();
  $profileItem = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  setErrorMessage("プロフィール項目取得失敗：".$e->getMessage());
}

// プロフィール項目の異常入力
$username = testInputValue($profileItem['username']);
$gender = testInputValue($profileItem['gender']);
$age = testInputValue($profileItem['age']);
$bloodType = testInputValue($profileItem['blood_type']);
$location = testInputValue($profileItem['location']);
$interests = testInputValue($profileItem['interests']);
$description = testInputValue($profileItem['description']);
$height = testInputValue($profileItem['height']);
$weight = testInputValue($profileItem['weight']);
$education = testInputValue($profileItem['education']);
$occupation = testInputValue($profileItem['occupation']);
$smokingHabits = testInputValue($profileItem['smoking_habits']);
$drinkingHabits = testInputValue($profileItem['drinking_habits']);

try {
  // 表示するユーザのプロフィール写真を取得
  $profilePicSql = 
    "SELECT picture_id, picture_contents, picture_type 
    FROM Profile_Pictures WHERE user_id = ?";
  $stmt = $conn->prepare($profilePicSql);
  $stmt->bindValue(1, $displayUserId);
  $stmt->execute();
  
  $profilePic = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $row = $stmt->rowCount();
} catch (PDOException $e) {
  setErrorMessage("プロフィール項目取得失敗：".$e->getMessage());
}
