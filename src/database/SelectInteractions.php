<?php
// ファイル名： SelectInteractions.php
// コード内容： いいね画面（DBの前処理）

include_once("Pdo.php");
include_once("../components/CheckValue.php");

$loginUserId = getUserIdSession();

try {
  // いいねできるユーザ一覧を取得
  $interactionListSql = 
  "SELECT u.user_id, u.username, u.gender, u.age, p.picture_contents, p.picture_type
  FROM Users u LEFT JOIN Profile_Pictures p ON u.user_id = p.user_id
  LEFT JOIN interactions i ON u.user_id = i.target_user_id AND i.user_id = :LoginId
  WHERE i.user_id IS NULL AND u.user_id != :LoginId;";
  $stmt = $conn->prepare($interactionListSql);
  $stmt->bindValue(':LoginId', $loginUserId, PDO::PARAM_INT);
  $stmt->execute();
  
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $row = $stmt->rowCount();
} catch (PDOException $e) {
  setErrorMessage("いいねする一覧の取得失敗しました: " . $e->getMessage());
}
if ($row === 0) {
  setErrorMessage("いいねする相手いません");
}