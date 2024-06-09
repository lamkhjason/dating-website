<?php 
// ファイル名： MatchedList.php
// コード内容： マッチング一覧画面（html部分）
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>マッチング一覧</title>
  </head>
  <body>
    <?php 
    include_once("../components/CheckValue.php");
    include_once("../database/SelectMatchedList.php");
    include_once("../components/CommonTools.php");
    ?>
    <main class="main-content">
      <div class="error-message"><?php displayErrorMessage();?></div>
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
        <div class="matched-card">
          <div class="matched-card-icon">
            <a href="Profile.php?targetUserId=<?php echo $targetUserId; ?>">
              <img 
                <?php echo "src='data: $pictureType; base64, $pictureContents'"; ?>
                class="matched-profile-pic"
              >
            </a>
          </div>
          <div class="matched-card-body">
            <h3 class="matched-card-title"><?php echo "$username ($age)"; ?></h3>
            <p class="matched-card-text"><?php echo $description; ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </main>
  </body>
</html>