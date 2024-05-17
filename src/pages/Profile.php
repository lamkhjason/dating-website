<?php 
// ファイル名： Profile.php
// コード内容： プロフィール画面（html部分）
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>プロフィール</title>
  </head>
  <body class="bg-info-subtle">
    <?php
    include_once("../components/CheckValue.php");
    include_once("../database/SelectProfileItem.php");
    include_once("../components/CommonTools.php");
    // プロフィールの連想配列
    $profileArray = [
      "性別" => $gender, 
      "年齢" => $age, 
      "血液型" => $bloodType,
      "出身地" => $location, 
      "趣味" => $interests, 
      "自己紹介" => $description,
    ];
    ?>
    <main class="main-content">
      <div class="error-message"><?php displayErrorMessage();?></div>
      <div class="row mx-3">
        <div class="col-md-6 p-4 card" style="height: 80vh;">
          <!-- プロフィール画像 -->
          <img 
            <?php echo "src='data: $pictureType; base64, $pictureContents'"; ?> 
            alt="profile_picture" class="object-fit-scale border rounded m-auto" 
            height="auto" width="auto" style="max-width: 300px;"
          >
          <!-- 自分のプロフィールを表示されるとき、プロフィール編集ボタンを表示する -->
          <?php if ($displayUserId === getUserIdSession()): ?>
            <div class="d-grid gap-2 col-8 mx-auto my-3">
              <a href="EditProfile.php" class="btn btn-secondary" type="button">
                <i class="bi-pencil-fill" style="font-size: 16px;"></i>
                プロフィール編集
              </a>
            </div>
          <?php endif; ?>
        </div>
        <div class="col-md-6 p-4 card overflow-y-auto text-break" style="height: 80vh;">
          <!-- 全プロフィール項目 -->
          <div class="mb-3 h1 strong"><?php echo $username; ?></div>
          <?php foreach ($profileArray as $key => $value): ?>
            <div class='hstack py-2'>
              <div class='p-2 h5 strong' style='min-width: 25%;'><?php echo $key; ?></div>
              <div class='vr' style="padding-left: 1px;"></div>
              <div class='p-2 mx-2'><?php echo $value; ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </main>
  </body>
</html>