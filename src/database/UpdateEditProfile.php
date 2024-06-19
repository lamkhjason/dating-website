<?php
// ファイル名： UpdateEditProfile.php
// コード内容： プロフィール編集画面（DBの後処理）

include_once("Pdo.php");
include_once("../components/CheckValue.php");

if (isset($_POST["editProfileSubmit"])) {
  // ユーザ名、性別と年齢が入力されているか
  $inputValue = !empty($_POST["username"]) && isset($_POST["gender"]) && 
    ($_POST["age"] !== "年齢を選択していください");
  if ($inputValue) {
    try {
      // 異常入力の確認
      $username = testInputValue($_POST["username"]);
      $age = testInputValue($_POST["age"]);
      $gender = testInputValue($_POST["gender"]);
      $bloodType = testInputValue($_POST["bloodType"]);
      $location = testInputValue($_POST["location"]);
      $interests = testInputValue($_POST["interests"]);
      $description = testInputValue($_POST["description"]);
      
      // 編集したプロフィールを更新
      $updateProfileSql = 
        "UPDATE Users SET username = ?, age = ?, gender = ?, blood_type = ?, 
        location = ?, interests = ?, description = ? WHERE user_id = ?";
      $stmt = $conn->prepare($updateProfileSql);
      $stmt->bindValue(1, $username);
      $stmt->bindValue(2, $age);
      $stmt->bindValue(3, $gender);
      $stmt->bindValue(4, $bloodType);
      $stmt->bindValue(5, $location);
      $stmt->bindValue(6, $interests);
      $stmt->bindValue(7, $description);
      $stmt->bindValue(8, getUserIdSession());
      $stmt->execute();
      
      header("Location: ../pages/Profile.php");
      exit;
    } catch (PDOException $e) {
      setErrorMessage("プロフィール更新失敗: " . $e->getMessage());
    }
  } else {
    setErrorMessage("名前、年齢、性別が必須項目です");
  }
  header("Location: ../pages/EditProfile.php");
  exit;
}