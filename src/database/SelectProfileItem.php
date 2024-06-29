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
$profile = [
  "username" => ["名前", testInputValue($profileItem['username'])],
  "age" => ["年齢", testInputValue($profileItem['age'])],
  "gender" => ["性別", testInputValue($profileItem['gender'])],
  "bloodType" => ["血液型", testInputValue($profileItem['blood_type'])],
  "location" => ["出身地", testInputValue($profileItem['location'])],
  "interests" => ["趣味", testInputValue($profileItem['interests'])],
  "description" => ["自己紹介", testInputValue($profileItem['description'])],
  "height" => ["身長", testInputValue($profileItem['height'])],
  "weight" => ["体重", testInputValue($profileItem['weight'])],
  "education" => ["学歴", testInputValue($profileItem['education'])],
  "occupation" => ["職業", testInputValue($profileItem['occupation'])],
  "smokingHabits" => ["喫煙", testInputValue($profileItem['smoking_habits'])],
  "drinkingHabits" => ["飲酒", testInputValue($profileItem['drinking_habits'])]
];

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