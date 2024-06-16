<?php
// ファイル名： SelectMessage.php
// コード内容： 対象のメッセージを取得（DB前処理）

include_once("Pdo.php");
include_once("../components/CheckValue.php");

$loginUserId = getUserIdSession();
$messageUserId = $_GET["messageUserId"];

if (isset($messageUserId)) {
  try {
    $matchedSql = 
    "SELECT i2.user_id, u.username, pp.picture_contents, pp.picture_type 
    FROM Interactions i1 INNER JOIN Interactions i2 ON i1.user_id = i2.target_user_id 
    AND i1.target_user_id = i2.user_id INNER JOIN Users u ON i2.user_id = u.user_id
    INNER JOIN Profile_Pictures pp ON u.user_id = pp.user_id
    WHERE i1.interaction_type = 'like' AND i2.interaction_type = 'like' 
    AND i1.user_id = ? AND i1.target_user_id = ?";
    $stmt = $conn->prepare($matchedSql);
    $stmt->bindValue(1, $loginUserId);
    $stmt->bindValue(2, $messageUserId);
    $stmt->execute();
    
    $matchedUser = $stmt->fetch(PDO::FETCH_ASSOC);
    $username = testInputValue($matchedUser['username']);
    $pictureContents = testInputValue($matchedUser['picture_contents']);
    $pictureType = testInputValue($matchedUser['picture_type']);
  } catch (PDOException $e) {
    setErrorMessage("プロフィール取得失敗：" . $e->getMessage());
    header('Location: ../pages/MatchedList.php');
    exit;
  }
    
  if ($matchedUser["user_id"] == $messageUserId) {
    try {
      $SelectMessageSql = 
      "SELECT m.sender_id, m.message_content, pp.picture_contents, pp.picture_type
      FROM Messages m LEFT JOIN Users u ON m.sender_id = u.user_id 
      LEFT JOIN Profile_Pictures pp ON m.sender_id = pp.user_id 
      WHERE m.sender_id = :loginUser AND m.receiver_id = :messageUser 
      OR m.sender_id = :messageUser AND m.receiver_id = :loginUser 
      ORDER BY m.timestamp ASC";
      $stmt = $conn->prepare($SelectMessageSql);
      $stmt->bindValue(":loginUser", $loginUserId, PDO::PARAM_INT);
      $stmt->bindValue(":messageUser", $messageUserId, PDO::PARAM_INT);
      $stmt->execute();
      
      $message = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      setErrorMessage("メッセージ取得失敗：" . $e->getMessage());
    }
  } else {
    setErrorMessage("マッチしていない相手とトークできません");
    header('Location: ../pages/MatchedList.php');
    exit;
  }  
}