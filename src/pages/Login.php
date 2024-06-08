<?php 
// ファイル名： Login.php
// コード内容： ログイン画面（html部分）
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>ログイン画面</title>
  </head>
  <body class="bg-info-subtle">
    <?php 
    include_once("../components/CheckValue.php");
    include_once("../components/CommonTools.php"); 
    ?>
    <main class="main-content">
      <form action="../database/ProcessLogin.php" method="POST" class="position-main">
        <div class="page-title">ログイン</div>
        <!-- ログインID -->
        <div class="login-id-area">
          <label for="loginId" class="form-label">ログインID</label>
          <input 
            type="text" name="loginId" 
            class="form-setting" 
          >
        </div>
        <!-- パスワード -->
        <div class="passwerd-area">
          <label for="password" class="form-label">パスワード</label>
          <input 
            type="password" name="password" 
            class="form-setting" 
          >
        </div>
        <!-- ログインボタンと新規登録ボタン -->
        <div class="col-6 d-grid gap-4 mx-auto">
          <button type="submit" class="btn-login" name="loginSubmit">
            ログイン
          </button>
          <a href='Register.php' class="btn-register">
            新規登録
          </a>
        </div>
        <div class="col-12 text-center text-danger">
          <?php displayErrorMessage();?>
        </div>
      </form>
    </main>
  </body>
</html>