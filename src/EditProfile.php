<?php 
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- cssファイルはいったんフレームワークを使用する -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>プロフィール編集画面</title>
  </head>
  <body class="bg-info-subtle">
    <?php
      include_once("Pdo.php");
      include_once("CommonTools.php");
      // include_once("LoginStatus.php");
      include_once("CheckInput.php");
      include_once("SelectProfileItem.php");

      define("MAX_SIZE", 1048576);
      
      function profileTextField($itemValue, $itemTitle, $itemKey) {
        echo "<label for='$itemKey' class='form-label'>$itemTitle</label>";
        echo "<input type='text' class='form-control form-control-lg' name='$itemKey' value='$itemValue'>";
      }
      function profileTextArea($itemValue, $itemTitle, $itemKey) {
        echo "<label for='$itemKey' class='form-label'>$itemTitle</label>";
        echo "<textarea class='form-control form-control-lg' name='$itemKey'>$itemValue</textarea>";
      }
      
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["editProfileSubmit"])) {
          $inputValue = !empty($_POST["username"]) && isset($_POST["gender"]) && 
            ($_POST["age"] !== "年齢を選択していください");

          if ($inputValue) {
            try {
              $conn->beginTransaction();

              $updateProfileSql = "UPDATE Users SET username = ?, age = ?, gender = ?,
                bloodType = ?, location = ?, interests = ?, description = ? WHERE userId = ?";
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

              $uploadPicture = is_uploaded_file($_FILES["profilePicture"]["tmp_name"]);
              if ($uploadPicture) {
                $pictureName = $_FILES["profilePicture"]["name"];
                $pictureType = $_FILES["profilePicture"]["type"];
                $pictureSize = $_FILES["profilePicture"]["size"];
                $pictureTmpName = $_FILES["profilePicture"]["tmp_name"];
                $pictureFile = file_get_contents($pictureTmpName);
                $pictureContents = base64_encode($pictureFile);
                
                if ($pictureSize <= MAX_SIZE) {
                  $updatePictureSql = 
                    "UPDATE User_Pictures SET pictureName = ?, pictureType = ?, 
                    pictureContents = ? WHERE userId = ?";
                  $stmt = $conn->prepare($updateProfileSql);
                  
                  $stmt->bindValue(1, $pictureName);
                  $stmt->bindValue(2, $pictureType);
                  $stmt->bindValue(3, $pictureContents);
                  $stmt->bindValue(4, $_POST["userId"]);
                  $stmt->execute();
                  
                  $conn->commit();
                  header("Location: Profile.php");
                } else {
                  $errorMessage = "画像サイズが1Mを超えました";
                  $conn->rollback();
                }
              } else {
                $conn->commit();
                header("Location: Profile.php");
              }
            } catch (Exception $e) {
              $errorMessage = "編集登録失敗しました";
              echo $e->getMessage();
              $conn->rollback();
            }
          } else {
            $errorMessage = "名前、年齢、性別が必須項目です";
          }
        }
      }
    ?>
    <div class="container p-4 bg-light">
      <form class="row g-4" method="POST" action="editProfile.php">
        <!-- username -->
        <div class="col-md-5">
          <?php profileTextField($result["username"], "名前", "username"); ?>
        </div>
        <!-- age -->
        <div class="col-md-3">
          <label for="age" class="form-label">年齢</label>
            <select class="form-select form-select-lg" name="age">
              <option>年齢を選択していください</option>
              <?php
                // Generate options for ages 18 to selected age
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
        <!-- gender -->
        <div class="col-md-4">
          <label for="gender" class="form-label">性別</label>
          <div class="form-check px-0">
            <div class="row">
              <div class="col-6 col-md-6 d-grid">
                <input 
                  type="radio" class="btn-check" name="gender" id="male" value="男"
                  <?php if ($gender === "男") echo "checked";?>
                >
                <label class="btn btn-outline-dark btn-lg px-5" for="male">男</label>
              </div>
              <div class="col-6 col-md-6 d-grid">
                <input 
                  type="radio" class="btn-check" name="gender" id="female" value="女"
                  <?php if ($gender === "女") echo "checked";?>
                >
                <label class="btn btn-outline-dark btn-lg px-5" for="female">女</label>
              </div>
            </div>
          </div>
        </div>
        <!-- bloodType -->
        <div class="col-md-6">
          <?php profileTextField($result["bloodType"], "血液型", "bloodType"); ?>
        </div>
        <!-- location -->
        <div class="col-md-6">
          <?php profileTextField($result["location"], "出身地", "location"); ?>
        </div>
        <!-- interests -->
        <div class="col-md-12">
          <?php profileTextArea($result["interests"], "趣味", "interests"); ?>
        </div>
        <!-- description -->
        <div class="col-md-12">
          <?php profileTextArea($result["description"], "自己紹介", "description"); ?>
        </div>
        <!-- profile picture -->
        <div class="col-md-12">
          <label for="profilePicture" class="form-label">プロフィール写真</label>
          <input 
            type="file" class="form-control form-control-lg" 
            id="profilePicture" name="profilePicture"
          >
        </div>
        <div class="col-12 text-center text-danger"><?php echo $errorMessage;?></div>
        <!-- submit -->
        <div class="col-md-6 d-grid">
          <input 
            type="submit" class="btn btn-outline-primary btn-lg my-2" 
            value="プロフィールを更新する" name="editProfileSubmit"
            formenctype="multipart/form-data"
          >
        </div>
        <!-- back to login page -->
        <div class="col-md-6 d-grid">
          <a type="button" href='Profile.php' class="btn btn-outline-dark btn-lg my-2">
            プロフィール画面に戻る
          </a>
        </div>
        <input type="hidden" name="userId" value="<?php echo $_SESSION["userId"];?>">
      </form>
    </div>
  </body>
</html>