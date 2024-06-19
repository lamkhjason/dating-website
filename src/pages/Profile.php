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
  <body>
    <?php
    include_once("../components/CheckValue.php");
    include_once("../database/SelectProfileItem.php");
    include_once("../components/CommonTools.php");
    // 項目が入力されているかの確認&プロフィールの連想配列
    $profileArray = [
      "性別" => checkProfileItem($gender), 
      "年齢" => checkProfileItem($age), 
      "血液型" => checkProfileItem($bloodType),
      "出身地" => checkProfileItem($location), 
      "趣味" => checkProfileItem($interests), 
      "自己紹介" => checkProfileItem($description)
    ];
    ?>
    <main class="main-content">
      <div class="error-message"><?php displayErrorMessage();?></div>
      <div class="profile">
        <div class="profile-left">
          <!-- プロフィール画像 -->
          <div class="pic-area" id="pictureCarousel">
            <button class="prev-btn" type="button">
              <i class="bi-caret-left-fill"></i>
            </button>
            <?php 
            for ($index = 0; $index < $row; $index++) {
              $picCon = testInputValue($profilePic[$index]['picture_contents']);
              $picType = testInputValue($profilePic[$index]['picture_type']);
              if ($index === 0) $picClass = "profile-pic active";
              else $picClass = "profile-pic";
              echo "<img src='data: $picType; base64, $picCon' class='$picClass'>";
            }
            ?>
            <button class="next-btn" type="button">
              <i class="bi-caret-right-fill"></i>
            </button>
          </div>
          <!-- 自分のプロフィールを表示されるとき、プロフィール編集ボタンを表示する -->
          <?php if ($displayUserId === getUserIdSession()): ?>
          <div class="profile-btn-area">
            <a href="EditProfile.php" class="edit-profile-btn" type="button">
              <i class="bi-pencil-fill"></i> プロフィール編集
            </a>
            <a href="EditProfilePic.php" class="edit-profile-btn" type="button">
              <i class="bi-camera-fill"></i> プロフィール写真編集
            </a>
          </div>
          <?php endif; ?>
        </div>
        <div class="profile-right">
          <!-- 全プロフィール項目 -->
          <div class="profile-username"><?php echo $username; ?></div>
          <?php foreach ($profileArray as $key => $value): ?>
            <div class='profile-item'>
              <div class='item-title'><?php echo $key; ?></div>
              <div class='item-body'><?php echo $value; ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </main>
    <script src="../js/CarouselPictures.js"></script>
  </body>
</html>