<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- cssファイルはいったんフレームワークを使用する -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>ログイン画面</title>
  </head>
  <body class="bg-info-subtle">
    <?php
      include_once("Pdo.php");
      include_once("CommonTools.php");
      include_once("CheckInput.php");

      $errorMessage = "";
      $loginid = $_POST["id"];
      $password = $_POST["pass"];
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") 
    {  
      if (isset($_POST["login"])) 
      {
        // ログインボタンを押したら
        try
        {
          if(empty($loginid) || empty($password))
          {
            $errorMessage = "ユーザー名またはパスワードが正しくありません。";
          }
          else
          {
            $sql = "SELECT * FROM Users WHERE login_id=? AND password=?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->bindValue(2, $password);
            $stmt->execute();
            $user = $stmt->fetch();
          }
            if($user)
            {
              $_SESSION['user_id'] = $user['user_id'];
              header('Location:Interation.php ');
              exit;
            }
            else 
            {
              $errorMessage = "ユーザー名またはパスワードが正しくありません。";
            }
        }catch(PDOException $e) {
          $errorMessage = "ログインに失敗しました。";
        }
      }
    }
    ?>

    <!-- menubarのコード -->
    <div class="sticky-top container-fluid bg-info py-3">
      <div class="row g-2">
        <div class="col-2">
          <img 
            src="../icon/calendar-heart-fill.svg" 
            width="40" height="40" class="mx-5"
          >
        </div>
      </div>
    </div>
    <!-- ログインのコード -->
    <main class="bg-info-subtle d-flex align-items-center py-4 bg-body-tertiary">
      <div class="position-relative container text-center">
      <form action="login.php" method="post" style="margin-top: 100px;">
        <div class="row my-4">
          <div class="position-static h1">
            <span class="m-2"> ログイン </span>
          </div>
        </div>
        <div class="row my-4">
          <div class="position-static h3">
            <span class="m-2"> ログインID </span> <input name="id" type="text"style="margin-left:14px;"/>
          </div>
        </div>

        <div class="row my-4">
          <div class="position-static h3">
            <span class="m-2"> パスワード </span> <input name="pass" type="password" style="margin-left:20px;"/>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <span class="text-danger"><?php echo $errorMessage ?></span>
          </div>
        </div>
        <div>
          <span class="m-4"><button class="btn btn-primary w-10" name="login" type="submit" style="border-right-width: 10px;border-left-width: 10px;">ログイン</button></span>
        </div><br>
      </form>
        <div>
          <a href="Regiter.php" class="btn btn-primary w-10" name="register" type="submit">新規登録</a>
        </div>
      </div> 
    </main>
  </body>
