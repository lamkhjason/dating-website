<?php
include_once("Pdo.php");
include_once("../components/CheckValue.php");

$loginUserId = getUserIdSession();

try {
  $conn->beginTransaction();
  
  $deleteMessage = "DELETE FROM Messages WHERE sender_id = ? OR receiver_id = ?";  
  $stmt = $conn->prepare($deleteMessage);
  $stmt->bindValue(1, $loginUserId);
  $stmt->bindValue(2, $loginUserId);
  $stmt->execute();
  
  $deleteInteractions = "DELETE FROM Interactions WHERE user_id = ? OR target_user_id = ?";
  $stmt = $conn->prepare($deleteInteractions);
  $stmt->bindValue(1, $loginUserId);
  $stmt->bindValue(2, $loginUserId);
  $stmt->execute();
  
  $deletePictures = "DELETE FROM Profile_Pictures WHERE user_id = ?";
  $stmt = $conn->prepare($deletePictures);
  $stmt->bindValue(1, $loginUserId);
  $stmt->execute();
  
  $deleteUser = "DELETE FROM Users WHERE user_id = ?";
  $stmt = $conn->prepare($deleteUser);
  $stmt->bindValue(1, $loginUserId);
  $stmt->execute();
  
  $conn->commit();
  session_unset();
  header("Location: ../pages/Login.php");
  exit();
  
} catch (PDOException $e) {
  $conn->rollBack();
  setErrorMessage("アカウント削除失敗しました: ". $e->getMessage());
  header("Location: ../pages/Profile.php");
}