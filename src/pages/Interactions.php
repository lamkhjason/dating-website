<?php
include_once("Pdo.php");
include_once("CheckValue.php");

$loginUserId = getUserIdSession();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
}

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
?>
<!DOCTYPE html>
<html>
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/Style.css">
    <title>いいね画面</title>
  </head>
  <body class="bg-info-subtle">
    <?php 
    include_once("CommonTools.php");
    // マッチング成立しているなら、成立した画面を表示
    $isMatched = getMatchedUserSession();
    if (isset($isMatched)):
    ?>
    <div class="z-3 bg-danger-subtle position-absolute w-100 h-100" id="success">
      <div 
        class="position-absolute text-center text-danger 
        top-50 start-50 translate-middle fs-1"
      >
        <i class="bi-arrow-through-heart-fill" style="font-size: 200px;"></i>
        <br>
        マッチ成立！！！！！ヒューヒュー
      </div>
    </div>
    <?php endif; ?>
    <main class="container p-4 bg-info-subtle">
      <div class="text-center text-danger"><?php displayErrorMessage();?></div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php 
        // 異常入力を確認し、画面に表示する
        foreach ($result as $user): 
          $targetUserId = testInputValue($user['user_id']);
          $username = testInputValue($user['username']);
          $age = testInputValue($user['age']);
          $gender = testInputValue($user['gender']);
          $pictureType = testInputValue($user['picture_type']);
          $pictureContents = testInputValue($user['picture_contents']);
        ?>
        <div class="col">
          <div class="card h-100 text-center">
            <a href="Profile.php?targetUserId=<?php echo $targetUserId; ?>">
              <img 
                <?php echo "src='data: $pictureType; base64, $pictureContents'"; ?>
                class="card-img-top object-fit-scale border rounded" 
                alt="profilePicture" height="300px" width="200px"
              >
            </a>
            <div class="card-body">
              <h5 class="card-title"><?php echo $username; ?></h5>
              <p class="card-text"><?php echo "$gender ($age)"; ?></p>
              <form class="d-grid" method="POST" action="Interactions.php">
                <input 
                  type="hidden" name="targetUserId" 
                  value="<?php echo $targetUserId; ?>"
                \>
                <button 
                  type="submit" class="btn btn-success" 
                  name="likeSubmit" value="like"
                > 
                  <i class="bi-heart-fill" style="font-size: 16px;"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </main>
  </body>
</html>