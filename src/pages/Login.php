<?php 
// ファイル名： Login.php
// コード内容： ログイン画面（html部分）
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../assets/icon/calendar-heart-fill.svg">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>ログイン画面</title>
  </head>
  <body>
    <?php 
    include_once("../components/CheckValue.php");
    include_once("../components/CommonTools.php"); 
    ?>
    <main class="main-content">
      <form action="../database/ProcessLogin.php" method="POST" class="form-row">
        <div class="page-title">ログイン</div>
        <!-- ログインID -->
        <div class="login-id-area">
          <label for="loginId" class="input-label">ログインID</label>
          <input type="text" name="loginId" class="input-area">
        </div>
        <!-- パスワード -->
        <div class="password-area">
          <label for="password" class="input-label">パスワード</label>
          <input type="password" name="password" class="input-area">
        </div>
        <!-- ログインボタンと新規登録ボタン -->
        <div class="login-btn-area">
          <button type="submit" class="btn-login" name="loginSubmit">ログイン</button>
          <a href='Register.php' class="btn-register">新規登録</a>
        </div>
      </form>
      <div class="error-message"><?php displayErrorMessage();?></div>
    </main>
  </body>
</html>