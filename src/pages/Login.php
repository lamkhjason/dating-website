<!-- 
  ファイル名： Login.php
  コード内容： ログイン画面（html部分）
-->
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../assets/css/Style.css">
    <title>ログイン画面</title>
  </head>
  <body class="bg-info-subtle">
    <?php 
    include_once("../components/CheckValue.php");
    include_once("../components/CommonTools.php"); 
    ?>
    <main class="main-content">
      <form action="../database/ProcessLogin.php" method="POST" class="row g-4 mx-3">
        <div class="col-12 text-center h2">ログイン</div>
        <!-- ログインID -->
        <div class="col-12 px-5">
          <label for="loginId" class="form-label">ログインID</label>
          <input 
            type="text" name="loginId" 
            class="form-control form-control-lg" 
          \>
        </div>
        <!-- パスワード -->
        <div class="col-12 px-5 mb-3">
          <label for="password" class="form-label">パスワード</label>
          <input 
            type="password" name="password" 
            class="form-control form-control-lg" 
          \>
        </div>
        <!-- ログインボタンと新規登録ボタン -->
        <div class="col-6 d-grid gap-4 mx-auto">
          <button type="submit" class="btn btn-primary btn-lg" name="loginSubmit">
            ログイン
          </button>
          <a href='Register.php' class="btn btn-dark btn-lg">
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