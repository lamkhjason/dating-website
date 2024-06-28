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
    <link rel="icon" href="../assets/icon/calendar-heart-fill.svg">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>プロフィール編集画面</title>
  </head>
  <body>
    <?php
    include_once("../components/CheckValue.php");
    include_once("../database/SelectProfileItem.php");
    include_once("../components/CommonTools.php");

    $editProfile = [
      ["username", "名前", $username],
      ["gender", "性別", $gender],
      ["age", "年齢", $age],
      ["bloodType", "血液型", $bloodType],
      ["location", "出身地", $location],
      ["interests", "趣味", $interests],
      ["description", "趣味", $description],
    ];
    $genderType = ["male" => "男性", "female" => "女性"]
    ?>
    <main class="main-content">
      <form method="POST" action="../database/UpdateEditProfile.php" class="form-row">
        <div class="page-title">プロフィール編集</div>
        <?php 
        foreach ($editProfile as $profileItem) {
          $itemKey = $profileItem[0];
          $itemTitle = $profileItem[1];
          $itemValue = $profileItem[2];

          echo "<div class='edit-$itemKey-area'>";
          echo "<label for='$itemKey' class='input-label'>$itemTitle</label>";
          if ($itemKey === "age") {
            echo "<select class='age-select' name='age'>";
            echo "<option>年齢を選択していください</option>";
            for ($ageRange = 18; $ageRange <= 100; $ageRange++) {
              if ($ageRange == $itemValue) $selected = "selected";
              echo "<option $selected value='$ageRange'>$ageRange</option>";
            }
            echo "</select>";
          } elseif ($itemKey === "gender") {
            echo "<div class='gender-btn-group'>";
            foreach ($genderType as $genderId => $genderValue) {
              echo "<input 
              type='radio' class='btn-check' name='gender' id='$genderId' value='$genderValue'";
              if ($gender === $genderValue) echo "checked";
              echo ">";
              echo "<label class='gender-btn' for='$genderId'>$genderValue</label>";
            }
            echo "</div>";
          } elseif ($itemKey === "interests" || $itemKey === "description") {
            echo "<textarea class='input-area' name='$itemKey'>$itemValue</textarea>";
          } else {
            echo "<input type='text' class='input-area' name='$itemKey' value='$itemValue'>";
          }
          echo "</div>";
        }
        ?>
        <div class="btn-area">
          <!-- プロフィール更新ボタン -->
          <input 
            type="submit" value="プロフィールを更新する" 
            name="editProfileSubmit" class="btn-update-profile"
          >
          <!-- プロフィール画面に戻るボタン -->
          <a type="button" href='Profile.php' class="btn-return-profile">
            プロフィール画面に戻る
          </a>
        </div>
      </form>
      <div class="error-message"><?php displayErrorMessage();?></div>
    </main>
  </body>
</html>