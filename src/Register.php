<?php
/*
 * FileName: Register.php
 * ScreenName: 新規登録画面
 */

session_start(); // session開始

include("Pdo.php"); // pdoファイルをインポート
include("CommonTools.php");
include("CheckInputValue.php");
include_once("SelectProfileItem.php");

// 定数定義
define("MAX_SIZE", 1048576); // 画像の最大サイズ
define("LOGIN_URL","./Login.php"); // ログイン画面のリンク

// エラーメッセージの初期化
$errorMessage = "";

// 新規登録ボタンが押された場合
if (isset($_POST["registerUserSubmit"])) {
  // 入力値のチェック
  if (empty($_POST["loginId"]) || empty($_POST["password"]) || empty($_POST["userName"]) || empty($_POST["gender"]) || empty($_POST["age"])) {
    $errorMessage = "必須項目を全て入力してください";
  } else {
    // 画像のアップロードチェック
    if (!isset($_FILES["profilePicture"]["error"]) || !is_uploaded_file($_FILES["profilePicture"]["tmp_name"])) {
      $errorMessage = "画像の登録は必須です";
    } elseif ($_FILES["profilePicture"]["size"] > MAX_SIZE) {
      $errorMessage = "画像サイズが1Mを超えました";
    } else {
      // 入力された値を取得
      $loginId = $_POST["loginId"];
      $userPass = $_POST["password"];
      $userName = $_POST["userName"];
      $gender = $_POST["gender"];
      $age = $_POST["age"];

      // loginIdが一意か確認
      $stmt = $pdo->prepare("SELECT * FROM Users WHERE user_id = ?");
      $stmt->bindValue(1, $loginId);
      $stmt->execute();
      $admin = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$admin) {
        try {
          $pdo->beginTransaction();

          // プロフィール情報を登録
          $stmt = $pdo->prepare("INSERT INTO Users (user_id, password, username) VALUES (?, ?, ?)");
          $stmt->bindValue(1, $loginId);
          $stmt->bindValue(2, $userPass);
          $stmt->bindValue(3, $userName);
          $stmt->execute();

          // 画像を登録
          $pictureTmpName = $_FILES["profilePicture"]["tmp_name"]; // 画像のデータを取得
          $pictureFile = file_get_contents($pictureTmpName); // 画像を取得
          $pictureContents = base64_encode($pictureFile); // 画像をエンコード
          $stmt = $pdo->prepare("INSERT INTO ProfilePictures (user_id, picture, picture_type) VALUES (?, ?, ?)");
          $stmt->bindValue(1, $loginId);
          $stmt->bindValue(2, $pictureContents);
          $stmt->bindValue(3, $_FILES["profilePicture"]["type"]);
          $stmt->execute();

          $pdo->commit();
          header("Location:".LOGIN_URL);
          exit();
        } catch (Exception $e) {
          $errorMessage = "新規登録に失敗しました";
          $pdo->rollback();
        }
      } else {
        $errorMessage = "既に使用されているIDです";
      }
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
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <title>新規登録画面</title>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form action="./Register.php" method="POST" enctype="multipart/form-data" class="login-content">
          <h1 class="text-center">Create an account</h1>
          <div class="register-form">
            <div class="mb-3">
              <label for="loginId" class="form-label"><b>loginId</b></label>
              <input type="text" name="loginId" class="form-control" placeholder="loginId">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label"><b>Password</b></label>
              <input type="password" name="password" class="form-control" placeholder="password">
            </div>
            <!-- username -->
            <div class="col-md-5">
              <label for="userName" class="form-label"><b>userName</b></label>
              <input type="text" name="userName" class="form-control" placeholder="userName">
            </div>
            <!-- age -->
            <div class="col-md-3">
              <label for="age" class="form-label"><b>age</b></label>
              <select class="form-select" name="age">
                <option>年齢を選択してください</option>
                <?php for ($ageRange = 18; $ageRange < 100; $ageRange++): ?>
                  <option value="<?php echo $ageRange; ?>"><?php echo $ageRange; ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <!-- gender -->
            <div class="col-md-4">
              <p><b>gender</b></p>
              <div class="form-check">
                <input type="radio" class="form-check-input" name="gender" id="male" value="男">
                <label class="form-check-label" for="male">男</label>
              </div>
              <div class="form-check">
                <input type="radio" class="form-check-input" name="gender" id="female" value="女">
                <label class="form-check-label" for="female">女</label>
              </div>
            </div>
            <!-- profile picture -->
            <div class="col-md-12">
              <p><b>profilePicture</b></p>
              <label for="profilePicture" class="form-label">プロフィール写真</label>
              <input type="file" class="form-control" id="profilePicture" name="profilePicture">
            </div>
            <!-- 新規登録ボタン -->
            <div class="col-md-6 d-grid">
              <input type="submit" class="btn btn-outline-primary btn-lg my-2" value="新規登録" name="registerUserSubmit" formenctype="multipart/form-data">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>