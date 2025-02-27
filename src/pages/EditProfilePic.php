<?php
// ファイル名： EditProfilePic.php
// コード内容： プロフィール写真編集画面（html部分）
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../assets/icon/calendar-heart-fill.svg">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>プロフィール写真編集画面</title>
  </head>
  <body>
    <?php
    include_once("../components/CheckValue.php");
    include_once("../database/SelectProfileItem.php");
    include_once("../components/CommonTools.php");
    ?>
    <main class="main-content">
      <form method="POST" action="../database/ProcessProfilePic.php" class="form-row">
        <div class="page-title">プロフィール写真編集</div>
        <!-- プロフィール写真 -->
        <?php 
        for ($index = 1; $index <= MAX_PIC; $index++): 
          if (!empty($profilePic[$index - 1]['picture_id'])) {
            $picCon = testInputValue($profilePic[$index - 1]['picture_contents']);
            $picType = testInputValue($profilePic[$index - 1]['picture_type']);
            $picId = testInputValue($profilePic[$index - 1]['picture_id']);

            $delBtnClass = "del-pic-btn";
            echo "<img src='data: $picType; base64, $picCon' class='edit-pic'>";
            echo "<input type='hidden' name='PicId_$index' value='$picId'>";
          } else {
            $delBtnClass = "del-pic-btn disable";
            echo "<div class='edit-pic'><i class='bi-person-plus-fill'></i></div>";
          } 
        ?>
        <button 
          type='submit' name='delPicSubmit' formenctype='multipart/form-data'
          <?php echo "value='$index' class='$delBtnClass'"; ?>
        >
          <i class='bi-trash-fill'></i>
        </button>
        <div class="upload-pic-area">
          <label class="input-label">プロフィール写真 <?php echo $index; ?></label>
          <?php echo "<input type='file' class='file-input' name='Pic_$index' id='Pic_$index'>"; ?>
        </div>
        <?php endfor; ?>
        <div class="btn-area">
          <!-- プロフィール更新ボタン -->
          <?php echo "<input type='hidden' name='uploadedPic' value='$row'>"; ?>
          <input 
            type="submit" value="写真を更新する" name="editProfilePicSubmit"
            formenctype="multipart/form-data" class="btn-update-profile"
          >
          <!-- プロフィール画面に戻るボタン -->
          <a type="button" href='Profile.php' class="btn-return-profile">
            プロフィール画面に戻る
          </a>
        </div>
      </form>
      <div class="error-message"><?php displayErrorMessage();?></div>
    </main>
  </body>
</html>