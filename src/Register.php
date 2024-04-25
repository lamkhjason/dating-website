<?php
  /*
   * FileName : Register.php
   * ScreenName : 新規登録画面
   */

  session_start(); // session開始
  include("pdo.php"); // pdoファイルをインポート
  include("CommonTools.php");
  include("CheckInputValue.php");

  // 定数定義
  Define("LOGIN_URL","./Login.php"); // ログイン画面のリンク
  

  // 新規登録ボタンが押された
  if (isset($_POST["registerUserSubmit"])){
    // 必須項目がそろっていない場合登録不可
    if (empty("userId") || empty("userPass") || empty("userName") || empty("gender") || empty("age")){
      $errorMessage = "必須項目を全て入力してください。"
    } else if (!is_uploaded_file($_FILES["icon"]["tmp_name"])) { // 画像の登録がない場合
      $errorMessage = "画像の登録は必須です。"
    else {
      // 入力された項目を保存
      $userId = $_POST["userId"];
      $userPass = $_POST["userPass"];
      $userName = $_POST["userName"];
      $gender = $_POST["gender"];
      $age = $_POST["age"]
      $icon = file_get_contents($_FILES["icon"]["tmp_name"]); // 画像を取得
      $icon_properties = getimageSize($_FILES["icon"]["tmp_name"]); // 画像のデータを取得
      $icon_type = $icon_properties["mime"]; // 画像の拡張子

      // IDが一意か確認
      $checkSql = "SELECT * FROM Users WHERE user_id = ?";
      $stmt = $pdo->prepare($checksql);
      $stmt->(1, $userId);
      $stmt->execute();
      $admin = $stmt->fetch(PDO::FETCH_ASSOC);

      if (empty($admin)){
        // IDが一意なら入力された項目をDBに登録
        $registerSql = "INSERT INTO Users (user_id, password, username, icon, icon_type) VALUES (?, ?, ?, ?, ?)";
        $stmt = pdo->prepare($registerSql);
        $stmt->bindValue(1, $userId);
        $stmt->bindValue(2, $userPass);
        $stmt->bindValue(3, $userName);
        $stmt->bindValue(4, $icon);
        $stmt->bindValue(5, $icon_type);

        if ($stmt->execute()){
            // 登録成功した場合ログイン画面へ遷移
            header("Location:".LOGIN_URL);
        } else {
            $errorMessage = "登録に失敗しました";
        }

      } else {
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
        <form action="./Register.php" method="POST" enctype="multipart/form-data" class="login-content">
          <h1>Create an account</h1>
          <!-- <?php //if (!empty($errorMessage)){
            // echo'<div style="color:red;font-weight:bold">'.$errorMessage.'</div>';
          // }?> -->
          <div class="register-form">
            <div>
              <p><b>userId</b></p>
              <input type="text" name="userId" class="input-form" placeholder="userId">
              <p><b>Password</b></p>
              <input type="password" name="password" class="input-form" placeholder="password">
              <p><b>userName</b></p>
              <input type="text" name="userName" class="input-form" placeholder="userName">
              <p><b>gender</b></p>
              <input type="radio" name="gender" class="input-form" placeholder="gender">
              <p><b>age</b></p>
              <input type="pulldown" name="age" class="input-form" placeholder="age">
              <p><b>icon</b></p>
              <input type="" name="icon" class="input-form" placeholder="icon">
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