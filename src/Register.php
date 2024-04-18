<?php
  /*
   * FileName : register_user.php
   * ScreenName : 新規登録画面
   */

  include("pdo.php");
  session_start();

  // 新規登録ボタンが押された
  if (isset($_POST["registerUserSubmit"])){
    // 必須項目がそろっていない場合登録不可
    if (empty("userId") || empty("userPass") || empty("userName")){
      $errorMessage = "ID、パスワード、名前は入力必須項目です。"
    } else {
      // 入力された項目を保存
      $userId = $_POST["userId"];
      $userPass = $_POST["userPass"];
      $userName = $_POST["userName"];

      // IDが一意か確認
      $checkSql = "SELECT * FROM Users WHERE userId = ?";
      $stmt = $pdo->prepare($checksql);
      $stmt->(1, $userId);
      $stmt->execute();
      $admin = $stmt->fetch(PDO::FETCH_ASSOC);

      if(empty($admin)){
        // IDが一意なら入力された項目をDBに登録
        $registerSql = "INSERT INTO Users (userId, userPass, userName) VALUES (?, ?, ?)";
        $stmt = pdo->prepare($registerSql);
        $stmt->bindValue(1, $userId);
        $stmt->bindValue(2, $userPass);
        $stmt->bindValue(3, $userName);

        if($stmt->execute()){
            // 登録成功した場合ログイン画面へ遷移
            header("Location:"login.php);
        }else{
            $errorMessage = "登録に失敗しました";
        }

      }else{
        $errorMessage = "既に使用されているIDです";
      }
    }
  }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- cssファイルはいったんフレームワークを使用する -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>新規登録画面</title>
  </head>
  <body>
    <div>
      <div>
        <!--ID、パスワード、名前の登録場所-->
        <form action="./register_user.php" method="POST" enctype="multipart/form-data" class="login-content">
          <h1>Create an account</h1>
          <?php if (!empty($errorMessage)){
            echo'<div style="color:red;font-weight:bold">'.$errorMessage.'</div>';
          }?>
          <div class="register-form">
            <div>
              <p><b>userId</b></p>
              <input type="text" name="userId" class="input-form" placeholder="userId">
              <p><b>Password</b></p>
              <input type="password" name="password" class="input-form" placeholder="password">
              <p><b>userName</b></p>
              <input type="text" name="userName" class="input-form" placeholder="userName">
            </div>
          </div>
          <br>
          <!--新規登録ボタン-->
          <nav>
            <div>
              <input type="submit" name="registerUserSubmit" value="registerUserSubmit" class="login"></input>
            </div>
          </nav>
        </form>
      </div>
    </div>
  </body>
</html>