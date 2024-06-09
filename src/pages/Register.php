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
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>新規登録画面</title>
  </head>
  <body>
    <?php
    include_once("../components/CheckValue.php");
    include_once("../components/CommonTools.php");
    ?>
    <main class="main-content">
      <form method="POST" action="../database/ProcessRegister.php" class="form-row">
        <div class="page-title">新規アカウント作成</div>
        <!-- ログインID -->
        <div class="reg-login-id-area">
          <label for="loginId" class="input-label">ログインID</label>
          <input type="text" name="loginId" class="input-area">
        </div>
        <!-- パスワード -->
        <div class="reg-password-area">
          <label for="password" class="input-label">パスワード</label>
          <input type="password" name="password" class="input-area">
        </div>
        <!-- 名前 -->
        <div class="reg-username-area">
          <label for="userName" class="input-label">名前</label>
          <input type="text" name="userName" class="input-area">
        </div>
        <!-- 年齢 -->
        <div class="reg-age-area">
          <label for="age" class="input-label">年齢</label>
          <select class="age-select" name="age">
            <option selected>年齢を選択してください</option>
            <?php
            // 年齢プルダウンの選択肢を生成
            for ($ageRange = 18; $ageRange <= 100; $ageRange++) {
              echo "<option value='$ageRange'>$ageRange</option>";
            }
            ?>
          </select>
        </div>
        <!-- 性別 -->
        <div class="reg-gender-area">
          <label for="gender" class="input-label">性別</label>
          <div class="gender-btn-group">
            <input type="radio" class="btn-check" name="gender" id="male" value="男">
            <label class="gender-btn" for="male">男</label>
            <input type="radio" class="btn-check" name="gender" id="female" value="女">
            <label class="gender-btn" for="female">女</label>
          </div>
        </div>
        <!-- プロフィール写真 -->
        <div class="reg-pic-area">
          <label for="profilePicture" class="input-label">プロフィール写真</label>
          <input type="file" class="file-input" name="profilePicture" id="profilePicture">
        </div>
        <!-- 新規登録ボタン -->
        <div class="reg-btn-area">
          <input 
            type="submit" value="登録する" name="registerUserSubmit" 
            formenctype="multipart/form-data" class="btn-new-register"
          >
        </div>
        <!-- ログイン画面に戻るボタン -->
        <div class="reg-btn-area">
          <a type="button" href='Login.php' class="btn-return-login">ログイン画面に戻る</a>
        </div>
      </form>
      <div class="error-message"><?php displayErrorMessage();?></div>
    </main>
  </body>
</html>