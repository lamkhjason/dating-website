<?php 
  session_start();

  $is_logged_in = isset($_SESSION['user_id']);
  $userid = $_POST["user_id"];

  if ($is_logged_in)
  {
    // データベースからユーザー情報を取得
    $sql = "SELECT * FROM Users WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $userid);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user)
    {
      // データベース内でユーザーが見つからない場合はログアウト
      session_destroy();
      header('Location: Login.php');
      exit;
    }
  } else
  {
    // ログインされていない場合はログインページにリダイレクト
    header('Location: Login.php');
    exit;
  }
  if (isset($_POST["logoutSubmit"]))
  {
    // セッションを破棄
    session_destroy();
    // ログインページにリダイレクト
    header('Location: Login.php');
    exit;
  }
?>
