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
  <body class="bg-info-subtle">
    <?php
    include_once("../components/CheckValue.php");
    include_once("../components/CommonTools.php");
    ?>
    <main class="container p-4">
      <form method="POST" action="../database/ProcessRegister.php" class="row g-4">
        <div class="col-12 text-center h2">新規アカウント作成</div>
        <!-- ログインID -->
        <div class="col-md-6">
          <label for="loginId" class="form-label">ログインID</label>
          <input 
            type="text" name="loginId"
            class="form-control form-control-lg" 
          >
        </div>
        <!-- バスワード -->
        <div class="col-md-6">
          <label for="password" class="form-label">バスワード</label>
          <input 
            type="password" name="password"
            class="form-control form-control-lg" 
          >
        </div>
        <!-- 名前 -->
        <div class="col-md-12">
          <label for="userName" class="form-label">名前</label>
          <input 
            type="text" name="userName"
            class="form-control form-control-lg" 
          >
        </div>
        <!-- 年齢 -->
        <div class="col-md-6">
          <label for="age" class="form-label">年齢</label>
          <select class="form-select form-select-lg" name="age">
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
        <div class="col-md-6">
          <label for="gender" class="form-label">性別</label>
          <div class="form-check px-0">
            <div class="btn-group btn-group-lg container px-0">
              <input 
                type="radio" class="btn-check" 
                name="gender" id="male" value="男"
              >
              <label class="btn btn-outline-dark" for="male">男</label>
              <input 
                type="radio" class="btn-check" 
                name="gender" id="female" value="女"
              >
              <label class="btn btn-outline-dark" for="female">女</label>
            </div>
          </div>
        </div>
        <!-- プロフィール写真 -->
        <div class="col-md-12 mb-3">
          <label for="profilePicture" class="form-label">プロフィール写真</label>
          <input 
            type="file" class="form-control form-control-lg" 
            name="profilePicture" id="profilePicture"
          >
        </div>
        <!-- 新規登録ボタン -->
        <div class="col-md-6 d-grid">
          <input 
            type="submit" class="btn btn-info btn-lg my-2" 
            value="登録する" name="registerUserSubmit"
            formenctype="multipart/form-data"
          >
        </div>
        <!-- ログイン画面に戻るボタン -->
        <div class="col-md-6 d-grid">
          <a type="button" href='Login.php' class="btn btn-dark btn-lg my-2">
            ログイン画面に戻る
          </a>
        </div>
        <div class="text-center text-danger"><?php displayErrorMessage();?></div>
      </form>
    </main>
  </body>
</html>