<!-- 
  ファイル名： Interactions.php
  コード内容： いいね画面（html部分）
-->
<!DOCTYPE html>
<html lang="ja">
  <head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../../assets/css/Style.css">
    <title>いいね画面</title>
  </head>
  <body class="bg-info-subtle">
    <?php 
    include_once("../components/CheckValue.php");
    include_once("../database/SelectInteractions.php");
    include_once("../components/CommonTools.php");
    // マッチング成立しているなら、成立した画面を表示
    $isMatched = getMatchedUserSession();
    if ($isMatched):
    ?>
    <div id="success">
      <i class="bi-arrow-through-heart-fill"></i>
      <h1>マッチ成立！！！！！ヒューヒュー</h1>
    </div>
    <?php endif; ?>
    <main class="main-content">
      <div class="error-message"><?php displayErrorMessage();?></div>
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
                <form 
                  action="../database/ProcessInteractions.php"
                  method="POST" class="d-grid"
                >
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