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
      // 編集したプロフィールを更新
      $updateProfileSql = 
        "UPDATE Users SET username = ?, age = ?, gender = ?, blood_type = ?, 
        location = ?, interests = ?, description = ?, height = ?, weight = ?, 
        education = ?, occupation = ?, smoking_habits = ?, drinking_habits = ? 
        WHERE user_id = ?";
      $stmt = $conn->prepare($updateProfileSql);
      
      $count = 1; // bindValueを数える変数
      foreach ($_POST as $postKey => $postValue) {
        if ($postKey !== "editProfileSubmit" && $postKey !== "profilePicture") {
          $postValue = testInputValue($postValue); // 異常入力の確認
          $stmt->bindValue($count, $postValue);
          $count++;
        }
      }
      $stmt->bindValue($count, getUserIdSession());
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