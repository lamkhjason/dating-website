<?php
// ファイル名： ProcessInteractions.php
// コード内容： いいね画面（DBの後処理）

include_once("Pdo.php");
include_once("../components/CheckValue.php");

$loginUserId = getUserIdSession();
$targetUserId = $_POST["targetUserId"];
$likeSubmit = $_POST["likeSubmit"];

if (isset($likeSubmit)) {
  try{
    // いいねをDBに登録
    $likeSql = 
      "INSERT INTO Interactions (user_id, target_user_id, interaction_type) 
      VALUES (:user_id, :target_user_id, :interaction_type)";
    $insert = $conn->prepare($likeSql);
    $insert->bindValue(':user_id', $loginUserId, PDO::PARAM_INT);
    $insert->bindValue(':target_user_id', $targetUserId, PDO::PARAM_INT);
    $insert->bindValue(':interaction_type', $likeSubmit, PDO::PARAM_STR);
    $result = $insert->execute();
    
    if ($result) {
      // 互いをいいねしたかを確認
      $checkMatchingSql = 
        "SELECT user_id FROM Interactions WHERE user_id = :target_user_id 
        AND target_user_id = :user_id AND interaction_type = :interaction_type";
      $select = $conn->prepare($checkMatchingSql);
      $select->bindValue(':target_user_id', $targetUserId, PDO::PARAM_INT);
      $select->bindValue(':user_id', $loginUserId, PDO::PARAM_INT);
      $select->bindValue(':interaction_type', $likeSubmit, PDO::PARAM_STR);
      $select->execute();
      
      $matched = $select->fetch(PDO::FETCH_ASSOC); 
      if ($matched) {
        // マッチング成立したらセッションに保存する
        setMatchedUserSession();
      }
    }
  } catch (PDOException $e) {
    setErrorMessage("いいね登録が失敗しました: " . $e->getMessage());
  }
}
header("Location: ../pages/Interactions.php");
exit();