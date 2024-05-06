<?php
include_once("Pdo.php");
include_once("CheckValue.php");

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
    AND i1.user_id = ?";
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
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/Style.css">
    <title>マッチング一覧</title>
  </head>
  <body class="bg-info-subtle">
    <?php include_once("CommonTools.php"); ?>
    <main class="container p-4 bg-info-subtle">
      <div class="text-center text-danger"><?php displayErrorMessage();?></div>
      <?php 
      // 異常入力を確認し、画面に表示する
      foreach ($result as $users):
        $targetUserId = testInputValue($users["user_id"]);
        $username = testInputValue($users["username"]);
        $age = testInputValue($users["age"]);
        $description = testInputValue($users["description"]);
        $pictureContents = testInputValue($users["picture_contents"]);
        $pictureType = testInputValue($users["picture_type"]);
      ?>
        <form method="GET" action="Message.php" class="card mb-2">
          <div class="row g-0">
            <div class="col-auto">
              <a href="Profile.php?targetUserId=<?php echo $targetUserId; ?>">
                <img 
                  <?php echo "src='data: $pictureType; base64, $pictureContents'"; ?> 
                  class="me-3 object-fit-scale border rounded"
                  height="150px" width="150px"
                >
              </a>
            </div>
            <div class="col-8">
              <div class="card-body">
                <h3 class="card-title"><?php echo "$username ($age) " ?></h3>
                <p class="card-text text-truncate"><?php echo $description ?></p>
              </div>
            </div>
          </div>
        </form>
      <?php endforeach; ?>
    </main>
  </body>
</html>