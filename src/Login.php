<?php
include_once("Pdo.php");
include_once("CheckValue.php");

// ログインボタンを押したら
if (isset($_POST["loginSubmit"])) {
  // 異常入力確認
  $loginId = testInputValue($_POST["loginId"]);
  $password = testInputValue($_POST["password"]);
  try {
    // 入力されているか
    if (empty($loginId) || empty($password)) {
      setErrorMessage("ログインIDとパスワードを入力してください");
    } else {
      // 一致しているかDBと確認
      $loginSql = "SELECT user_id FROM Users WHERE login_id = ? AND password = ?";
      $stmt = $conn->prepare($loginSql);
      $stmt->bindValue(1, $loginId);
      $stmt->bindValue(2, $password);
      $stmt->execute();
      
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!empty($user)) {
        // ログインしているユーザIDをセンションに登録し、いいね画面に遷移する
        setUserIdSession($user['user_id']);
        header('Location: Interactions.php');
        exit;
      } else {
        setErrorMessage("ログインIDまたはパスワードが正しくありません");
      }
    }
  } catch (PDOException $e) {
    setErrorMessage("ログインに失敗しました: " . $e->getMessage());
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/Style.css">
    <title>ログイン画面</title>
  </head>
  <body class="bg-info-subtle">
    <?php include_once("CommonTools.php"); ?>
    <main class="container p-4 mt-4 bg-info-subtle">
      <form action="Login.php" method="POST" class="row g-4 mx-3">
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
