<?php
// ファイル名： Register.php
// コード内容： 新規登録画面（html部分）
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../assets/icon/calendar-heart-fill.svg">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>新規登録画面</title>
  </head>
  <body>
    <?php
    include_once("../components/CheckValue.php");
    include_once("../components/CommonTools.php");
    include_once("../components/FormLayout.php");
    ?>
    <main class="main-content">
      <form method="POST" action="../database/ProcessRegister.php" class="form-row">
        <div class="page-title">新規アカウント作成</div>
        <?php 
        $registerItems = [
          "loginId" => "ログインID", "password" => "パスワード",
          "username" => "名前", "age" => "年齢", "gender" => "性別"
        ];
        foreach ($registerItems as $itemKey => $itemValue) {
          echo "<div class='reg-$itemKey-area'>";
          echo "<label for='$itemKey' class='input-label'>$itemValue</label>";
          if ($itemKey === "age") agePulldown(null);
          elseif ($itemKey === "gender") genderRadioBtn(null);
          else inputField($itemKey, $itemValue, null);
          echo "</div>";
        }
        ?>
        <!-- プロフィール写真 -->
        <div class="reg-pic-area">
          <label for="profilePicture" class="input-label">プロフィール写真</label>
          <input type="file" class="file-input" name="profilePicture" id="profilePicture">
        </div>
        <div class="btn-area">
          <!-- 新規登録ボタン -->
          <input 
            type="submit" value="登録する" name="registerUserSubmit" 
            formenctype="multipart/form-data" class="btn-new-register"
          >
          <!-- ログイン画面に戻るボタン -->
          <a type="button" href='Login.php' class="btn-return-login">ログイン画面に戻る</a>
        </div>
      </form>
      <div class="error-message"><?php displayErrorMessage();?></div>
    </main>
  </body>
</html>