<!-- 
  ファイル名： MatchedList.php
  コード内容： マッチング一覧画面（html部分）
-->
<!DOCTYPE html>
<html lang="ja">
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../../assets/css/Style.css">
    <title>マッチング一覧</title>
  </head>
  <body class="bg-info-subtle">
    <?php 
    include_once("../components/CheckValue.php");
    include_once("../database/SelectMatchedList.php");
    include_once("../components/CommonTools.php");
    ?>
    <main class="main-content">
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
        <div class="card mb-2">
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
                <h3 class="card-title"><?php echo "$username ($age)"; ?></h3>
                <p class="card-text text-truncate"><?php echo $description; ?></p>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </main>
  </body>
</html>