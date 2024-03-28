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
    <!-- <?php
      include_once("Pdo.php");
      include_once("CommonTools.php");
      include_once("LoginStatus.php");
      include_once("CheckInput.php");
      include_once("SelectProfileItem.php");
      
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
    ?> -->
    <!-- menubarのコード -->
    <div class="sticky-top container-fluid bg-info py-3">
      <div class="row g-2">
        <div class="col-2">
          <img 
            src="../icon/calendar-heart-fill.svg" 
            width="40" height="40" class="mx-5"
          >
        </div>
        <!-- <?php 
          if ($_SERVER["SCRIPT_NAME"] !== "/dating-app/src/Login.php" && 
            $_SERVER["SCRIPT_NAME"] !== "/dating-app/src/Register.php") { 
        ?> -->
          <div class="col-8">
            <div class="btn-group container">
              <!-- <?php 
                foreach ($menubar as $fileName => $value) {
                  $btnClass = checkActive($fileName);
                  echo "<a href='$fileName' class='$btnClass'>$value</a>";
                }
              ?> -->
              <a href="" class="btn btn-outline-dark">マッチング一覧</a>
              <a href="" class="btn btn-outline-dark">いいね</a>
              <a href="" class="btn btn-outline-dark active">プロフィール</a>
            </div>
          </div>
          
          <div class="col-2">
            <div class="btn-group container justify-content-end">
              <!-- <form method="POST" action="<?php echo htmlspecialchars($_SERVER["SCRIPT_NAME"]);?>"> -->
              <form method="POST" action="">
                <button type="submit" name="logoutSubmit" class="btn btn-link p-0">
                  <img src="../icon/box-arrow-right.svg" width="40" height="40" class="mx-5">
                </button>
              </form>
            </div>
          </div>
        <!-- <?php } ?> -->
      </div>
    </div>

    <!-- menubarのコード -->

    <div class="container p-4 bg-light">
      <form class="row g-4" method="POST" action="editProfile.php">
        <!-- username -->
        <div class="col-md-5">
          <!-- <?php profileTextField($result["username"], "名前", "username"); ?> -->
          <label for='username' class='form-label'>名前</label>
          <input type='text' class='form-control form-control-lg' 
          name='username' placeholder='名前を入力して下さい' value=''>
        </div>
        <!-- age -->
        <div class="col-md-3">
          <label for="age" class="form-label">年齢</label>
            <select class="form-select form-select-lg" name="age">
              <option>年齢を選択していください</option>
              <option value='18'>18</option>
              <option selected value='19'>19</option>
              <!-- <?php
                // Generate options for ages 18 to selected age
                for ($ageRange = 18; $ageRange < 100; $ageRange++) {
                  if ($ageRange === $age) {
                    echo "<option selected value='$age'>$age</option>";
                  } else {
                    echo "<option value='$ageRange'>$ageRange</option>";
                  }
                }
              ?> -->
            </select>
        </div>
        <!-- gender -->
        <div class="col-md-4">
          <label for="gender" class="form-label">性別</label>
          <div class="form-check px-0">
            <div class="row">
              <div class="col-6 col-md-6 d-grid">
                <input 
                  type="radio" class="btn-check" name="gender" id="male" 
                  value="男" checked>
                  <!-- <?php if ($gender === "男") echo "checked";?> -->
                <label class="btn btn-outline-dark btn-lg px-5" for="male">男</label>
              </div>
              <div class="col-6 col-md-6 d-grid">
                <input 
                  type="radio" class="btn-check" name="gender" 
                  id="female" value="女"
                >
                <!-- <?php if ($gender === "女") echo "checked";?> -->
                <label class="btn btn-outline-dark btn-lg px-5" for="female">女</label>
              </div>
            </div>
          </div>
        </div>
        <!-- height -->
        <div class="col-md-3">
          <label for='height' class='form-label'>身長</label>
          <input type='text' class='form-control form-control-lg' 
          name='height' placeholder='身長を入力して下さい' value=''>
        </div>
        <!-- weight -->
        <div class="col-md-3">
          <label for='weight' class='form-label'>項目名</label>
          <input type='text' class='form-control form-control-lg' 
          name='weight' placeholder='項目名を入力して下さい' value='テスト'>
        </div>
        <!-- blood Type -->
        <div class="col-md-3">
          <label for='bloodType' class='form-label'>項目名</label>
          <input type='text' class='form-control form-control-lg' 
          name='bloodType' placeholder='項目名を入力して下さい' value='テスト'>
          <!-- <?php profileTextField($result["bloodType"], "血液型", "bloodType"); ?> -->
        </div>
        <!-- location -->
        <div class="col-md-3">
          <label for='location' class='form-label'>項目名</label>
          <input type='text' class='form-control form-control-lg' 
          name='location' placeholder='項目名を入力して下さい' value='テスト'>
          <!-- <?php profileTextField($result["location"], "出身地", "location"); ?> -->
        </div>
        <!-- interests -->
        <div class="col-md-12">
          <label for='interests' class='form-label'>趣味</label>
          <textarea class='form-control form-control-lg' name='interests' 
          placeholder='趣味を入力して下さい'>ttttttttttttttttttttttttttttttttest</textarea>
          <!-- <?php profileTextArea($result["interests"], "趣味", "interests"); ?> -->
        </div>
        <!-- description -->
        <div class="col-md-12">
          <label for='description' class='form-label'>自己紹介</label>
          <textarea class='form-control form-control-lg' name='description' 
          placeholder='自己紹介を入力して下さい'>ttttttttttttttttttttttttttttttttest</textarea>
          <!-- <?php profileTextArea($result["description"], "自己紹介", "description"); ?> -->
        </div>
        
        <!-- profile picture -->
        <!-- <div class="col-md-12">
          <label for="profilePicture" class="form-label">Profile Picture</label>
          <input 
            type="file" class="form-control form-control-lg" 
            id="profilePicture" name="profilePicture"
          >
        </div> -->
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
        <!-- <input type="hidden" name="userId" value="<?php echo $_SESSION["userId"];?>"> -->
      </form>
    </div>
  </body>
</html>