<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- cssファイルはいったんフレームワークを使用する -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>プロフィール画面</title>
  </head>
  <body class="bg-info-subtle">
    <?php
      include_once("Pdo.php");
      include_once("CommonTools.php");
      // include_once("LoginStatus.php");
      include_once("CheckInput.php");
      include_once("SelectProfileItem.php");
    ?>
    <div class="container p-4 bg-light">
      <div class="row">
        <div class="col-md-6 text-center mb-3">
          <img 
            <?php echo "src='data: $pictureType; base64, $pictureContents'"; ?> 
            alt="profile_picture" class="object-fit-scale border rounded" 
            height="auto" width="auto" style="max-width: 300px;"
          >
        </div>
        <div class="col-md-6 px-4">
          <div class="row">
            <div class="col-9 col-md-9 h1 strong">
              <?php echo $username ?>
            </div>
            <div class="col-3 col-md-3">
              <?php if ($displayUserId === $_SESSION["userId"]) { ?>
                <a class="float-end" href="EditProfile.php">
                  <img src="../icon/pencil-square.svg" width="32" height="32" class="m-2">
                </a>
              <?php } ?>
            </div>
          </div>
          <?php
            foreach ($profileArray as $key => $value) {
              echo "<div class='row my-4'>
                <div class='col-md-4 h4'>$key</div>
                <div class='col-md-8 h6'>$value</div></div>";
            }
          ?>
        </div>
      </div>
    </div>
  </body>
</html>