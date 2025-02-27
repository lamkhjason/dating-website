<?php
// ファイル名： SelectMatchedList.php
// コード内容： マッチング一覧画面（DBの前処理）

include_once("Pdo.php");
include_once("../components/CheckValue.php");

$search = "";
$input = "";
if (isset($_POST["SearchSubmit"])) {
  $input = $_POST["SearchUserName"];
  $search = "AND u.username LIKE '%$input%'";
}

try {
  // マッチ一覧を取得
  $matchedSql = 
    "SELECT i2.user_id, u.username, u.age, u.description, 
    pp.picture_contents, pp.picture_type FROM Interactions i1 
    INNER JOIN Interactions i2 ON i1.user_id = i2.target_user_id 
    AND i1.target_user_id = i2.user_id
    INNER JOIN Users u ON i2.user_id = u.user_id
    INNER JOIN Profile_Pictures pp ON u.user_id = pp.user_id
    WHERE i1.interaction_type = 'like' AND i2.interaction_type = 'like' 
    AND i1.user_id = ? $search GROUP BY i2.user_id";
  $stmt = $conn->prepare($matchedSql);
  $stmt->bindValue(1, getUserIdSession());
  $stmt->execute();
  
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $row = $stmt->rowCount();
} catch (PDOException $e) {
  setErrorMessage("マッチ一覧を取得失敗:" . $e->getMessage());
}
if ($row === 0) {
  setErrorMessage("マッチした相手がいません");
}