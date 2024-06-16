<?php
// ファイル名： SendMessage.php
// コード内容： メッセージを送信（DBに登録）

include_once("Pdo.php");
include_once("../components/CheckValue.php");

if (isset($_POST["sendMessage"])) {
  $message = testInputValue($_POST["message"]);
  $messageUserId = testInputValue($_POST["messageUserId"]);
  $loginUserId = getUserIdSession();
  if (!empty($message)) {
    try {
      $insertMessageSql = 
        "INSERT INTO Messages (sender_id, receiver_id, message_content) VALUES (?, ?, ?)";
      $stmt = $conn->prepare($insertMessageSql);
      $stmt->bindValue(1, $loginUserId);
      $stmt->bindValue(2, $messageUserId);
      $stmt->bindValue(3, $message);
      $stmt->execute();
      
    } catch (PDOException $e) {
      $errorMessage = "送信失敗: " . $e->getMessage();
      setErrorMessage($errorMessage);
    }
  } else {
    $errorMessage = "メッセージを入力してください";
    setErrorMessage($errorMessage);
  }
  header("Location: ../pages/Message.php?messageUserId=$messageUserId");
  exit;
}