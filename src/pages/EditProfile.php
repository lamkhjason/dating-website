<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../../assets/css/Style.css">
    <title>プロフィール編集画面</title>
  </head>
  <body class="bg-info-subtle">
    <?php
    include_once("../components/CheckValue.php");
    include_once("../database/SelectProfileItem.php");
    include_once("../components/CommonTools.php");
    
    function profileTextField($itemValue, $itemTitle, $itemKey) {
      echo "<label for='$itemKey' class='form-label'>$itemTitle</label>";
      echo "<input type='text' class='form-control form-control-lg' 
        name='$itemKey' placeholder='$itemTitle"."を入力して下さい' value='$itemValue'>";
    }
    function profileTextArea($itemValue, $itemTitle, $itemKey) {
      echo "<label for='$itemKey' class='form-label'>$itemTitle</label>";
      echo "<textarea class='form-control form-control-lg' name='$itemKey' 
        placeholder='$itemTitle"."を入力して下さい'>$itemValue</textarea>";
    }
    ?>
    <main class="container p-4 bg-info-subtle">
      <form class="row g-4" method="POST" action="../database/UpdateEditProfile.php">
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
                if ($ageRange == $age) {
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