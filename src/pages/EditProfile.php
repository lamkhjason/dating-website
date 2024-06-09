<?php
// ファイル名： EditProfile.php
// コード内容： プロフィール編集画面（html部分）
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>プロフィール編集画面</title>
  </head>
  <body>
    <?php
    include_once("../components/CheckValue.php");
    include_once("../database/SelectProfileItem.php");
    include_once("../components/CommonTools.php");
    
    function profileTextField($itemValue, $itemTitle, $itemKey) {
      echo "<label for='$itemKey' class='input-label'>$itemTitle</label>
        <input type='text' class='input-area' name='$itemKey' value='$itemValue'>";
    }
    function profileTextArea($itemValue, $itemTitle, $itemKey) {
      echo "<label for='$itemKey' class='form-label'>$itemTitle</label>
        <textarea class='input-area' name='$itemKey'>$itemValue</textarea>";
    }
    ?>
    <main class="main-content">
      <form method="POST" action="../database/UpdateEditProfile.php" class="form-row">
        <div class="page-title">プロフィール編集</div>
        <!-- 名前 -->
        <div class="col-md-6">
          <?php profileTextField($profileItem['username'], "名前", "username"); ?>
        </div>
        <!-- 年齢 -->
        <div class="col-md-6">
          <label for="age" class="form-label">年齢</label>
          <select class="age-select" name="age">
            <option>年齢を選択していください</option>
            <?php
            $age = $profileItem["age"];
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
          <div class="gender-btn-group">
            <input 
              type="radio" class="btn-check" name="gender" id="male" value="男"
              <?php if ($profileItem['gender'] === "男") echo "checked";?>
            >
            <label class="gender-btn" for="male">男</label>
            <input 
              type="radio" class="btn-check" name="gender" id="female" value="女"
              <?php if ($profileItem['gender'] === "女") echo "checked";?>
            >
            <label class="gender-btn" for="female">女</label>
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
          <input type="file" class="file-input" name="profilePicture" id="profilePicture">
        </div>
        <div class="btn-area">
          <!-- プロフィール更新ボタン -->
          <input 
            type="submit" value="プロフィールを更新する" name="editProfileSubmit"
            formenctype="multipart/form-data" class="btn btn-primary btn-lg"
          >
          <!-- プロフィール画面に戻るボタン -->
          <a type="button" href='Profile.php' class="btn btn-dark btn-lg">プロフィール画面に戻る</a>
        </div>
        <input type="hidden" name="userId" value="<?php echo getUserIdSession()?>">
      </form>
      <div class="error-message"><?php displayErrorMessage();?></div>
    </main>
  </body>
</html>