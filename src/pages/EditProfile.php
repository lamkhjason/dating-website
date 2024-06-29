<?php
// ファイル名： EditProfile.php
// コード内容： プロフィール編集画面（html部分）
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../assets/icon/calendar-heart-fill.svg">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>プロフィール編集画面</title>
  </head>
  <body>
    <?php
    include_once("../components/CheckValue.php");
    include_once("../database/SelectProfileItem.php");
    include_once("../components/CommonTools.php");
    include_once("../components/FormLayout.php");
    ?>
    <main class="main-content">
      <form method="POST" action="../database/UpdateEditProfile.php" class="form-row">
        <div class="page-title">プロフィール編集</div>
        <?php 
        foreach ($profile as $itemKey => $arrayValue) {
          echo "<div class='edit-$itemKey-area'>";
          echo "<label for='$itemKey' class='input-label'>".$arrayValue[0]."</label>";
          if ($itemKey === "age") agePulldown($arrayValue[1]);
          elseif ($itemKey === "gender") genderRadioBtn($arrayValue[1]);
          else inputField($itemKey, $arrayValue[0], $arrayValue[1]);
          echo "</div>";
        }
        ?>
        <div class="btn-area">
          <!-- プロフィール更新ボタン -->
          <input 
            type="submit" value="プロフィールを更新する" 
            name="editProfileSubmit" class="btn-update-profile"
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