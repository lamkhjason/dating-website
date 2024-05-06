<?php
include_once("Pdo.php");
include_once("CheckValue.php");
include_once("SelectProfileItem.php");

function profileTextField($itemValue, $itemTitle, $itemKey) {
  echo "<label for='$itemKey' class='form-label'>$itemTitle</label>";
  echo "<input type='text' class='form-control form-control-lg' 
    name='$itemKey' value='$itemValue'>";
}
function profileTextArea($itemValue, $itemTitle, $itemKey) {
  echo "<label for='$itemKey' class='form-label'>$itemTitle</label>";
  echo "<textarea class='form-control form-control-lg' 
    name='$itemKey'>$itemValue</textarea>";
}

if (isset($_POST["editProfileSubmit"])) {
  // ユーザ名、性別と年齢が入力されているか
  $inputValue = !empty($_POST["username"]) && isset($_POST["gender"]) && 
    ($_POST["age"] !== "年齢を選択していください");
  if ($inputValue) {
    try {
      // トランザクション開始
      $conn->beginTransaction();
      // 編集したプロフィールを更新
      $updateProfileSql = "UPDATE Users SET username = ?, age = ?, gender = ?,
        blood_type = ?, location = ?, interests = ?, description = ? WHERE user_id = ?";
      $stmt = $conn->prepare($updateProfileSql);
      $count = 1;
      foreach ($_POST as $postKey => $postValue) {
        if ($postKey !== "editProfileSubmit" && $postKey !== "profilePicture") {
          $postValue = testInputValue($postValue);
          $stmt->bindValue($count, $postValue);
          $count++;
        }
      }
      $stmt->execute();
      // プロフィール写真を更新しているか
      $uploadPicture = is_uploaded_file($_FILES["profilePicture"]["tmp_name"]);
      if ($uploadPicture) {
        // 画像情報を取得
        $pictureName = $_FILES["profilePicture"]["name"];
        $pictureType = $_FILES["profilePicture"]["type"];
        $pictureSize = $_FILES["profilePicture"]["size"];
        $pictureTmpName = $_FILES["profilePicture"]["tmp_name"];
        $pictureFile = file_get_contents($pictureTmpName);
        $pictureContents = base64_encode($pictureFile);
        
        // アップロードした画像のサイズ確認
        if ($pictureSize <= MAX_SIZE) {
          //DBを更新する 
          $updatePictureSql = 
            "UPDATE Profile_Pictures SET picture_name = ?, picture_type = ?, 
            picture_contents = ? WHERE user_id = ?";
          $stmt = $conn->prepare($updatePictureSql);
          $stmt->bindValue(1, $pictureName);
          $stmt->bindValue(2, $pictureType);
          $stmt->bindValue(3, $pictureContents);
          $stmt->bindValue(4, getUserIdSession());
          $stmt->execute();
          
          // 画像とプロフィール情報が登録成功したらコミットする
          $conn->commit();
          header("Location: Profile.php");
          exit;
        } else {
          // サイズが1Mを超えたらロールバックする
          setErrorMessage("画像サイズが1Mを超えました");
          $conn->rollback();
        }
      } else {
        // プロフィール情報が登録成功したらコミットする
        $conn->commit();
        header("Location: Profile.php");
        exit;
      }
    } catch (Exception $e) {
      setErrorMessage("プロフィール更新失敗: " . $e->getMessage());
      // 片方失敗したらロールバックする
      $conn->rollback();
    }
  } else {
    setErrorMessage("名前、年齢、性別が必須項目です");
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/Style.css">
    <title>プロフィール編集画面</title>
  </head>
  <body class="bg-info-subtle">
    <?php include_once("CommonTools.php"); ?>
    <main class="container p-4 bg-info-subtle">
      <form class="row g-4" method="POST" action="EditProfile.php">
        <!-- 名前 -->
        <div class="col-md-7">
          <?php profileTextField($profileItem['username'], "名前", "username"); ?>
        </div>
        <!-- 年齢 -->
        <div class="col-md-5">
          <label for="age" class="form-label">年齢</label>
            <select class="form-select form-select-lg" name="age">
              <option>年齢を選択していください</option>
              <?php
              $age = $profileItem['age'];
              for ($ageRange = 18; $ageRange < 100; $ageRange++) {
                if ($ageRange === $age) {
                  echo "<option selected value='$age'>$age</option>";
                } else {
                  echo "<option value='$ageRange'>$ageRange</option>";
                }
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
                type="radio" class="btn-check" name="gender" id="male" value="男"
                <?php if ($profileItem['gender'] === "男") echo "checked";?>
              \>
              <label class="btn btn-outline-dark" for="male">男</label>
              <input 
                type="radio" class="btn-check" name="gender" id="female" value="女"
                <?php if ($profileItem['gender'] === "女") echo "checked";?>
              \>
              <label class="btn btn-outline-dark" for="female">女</label>
            </div>
          </div>
        </div>
        <!-- 血液型 -->
        <div class="col-md-3">
          <?php profileTextField($profileItem['blood_type'], "血液型", "bloodType"); ?>
        </div>
        <!-- 出身地 -->
        <div class="col-md-3">
          <?php profileTextField($profileItem['location'], "出身地", "location"); ?>
        </div>
        <!-- 趣味 -->
        <div class="col-md-12">
          <?php profileTextArea($profileItem['interests'], "趣味", "interests"); ?>
        </div>
        <!-- 自己紹介 -->
        <div class="col-md-12">
          <?php profileTextArea($profileItem['description'], "自己紹介", "description"); ?>
        </div>
        <!-- プロフィール写真 -->
        <div class="col-md-12">
          <label for="profilePicture" class="form-label">プロフィール写真</label>
          <input 
            type="file" class="form-control form-control-lg" 
            name="profilePicture" id="profilePicture"
          \>
        </div>
        <!-- プロフィール更新ボタン -->
        <div class="col-md-6 d-grid">
          <input 
            type="submit" class="btn btn-primary btn-lg my-2" 
            value="プロフィールを更新する" name="editProfileSubmit"
            formenctype="multipart/form-data"
          \>
        </div>
        <!-- プロフィール画面に戻るボタン -->
        <div class="col-md-6 d-grid">
          <a type="button" href='Profile.php' class="btn btn-dark btn-lg my-2">
            プロフィール画面に戻る
          </a>
        </div>
        <input type="hidden" name="userId" value="<?php echo getUserIdSession()?>">
        <div class="text-center text-danger"><?php displayErrorMessage();?></div>
      </form>
    </main>
  </body>
</html>