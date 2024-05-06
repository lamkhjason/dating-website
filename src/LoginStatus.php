<?php
session_start();
include_once("Pdo.php");
include_once("CheckValue.php");

try {
  $isLoggingIn = getUserIdSession();
  if ($isLoggingIn) {
    // データベースからユーザーID情報を取得
    $checkUserSql = "SELECT user_id FROM Users WHERE user_id = ?";
    $stmt = $conn->prepare($checkUserSql);
    $stmt->bindValue(1, $isLoggingIn);
    $stmt->execute();
    
    $loginUser = $stmt->rowCount();
    if ($loginUser === 0) {
      // データベース内でユーザーが見つからない
      setErrorMessage("ユーザ情報がありません");
      header('Location: Login.php');
      exit;
    }
  } else {
    // ログインされていない場合はログインページにリダイレクト
    setErrorMessage("ログインしていません");
    header('Location: Login.php');
    exit;
  }
} catch (PDOException $e) {
  setErrorMessage("DBエラー：".$e->getMessage());
  header("Location: Login.php");
  exit;
}

// ログアウトボタンをクリック
if (isset($_POST["logoutSubmit"])) {
  // セッションを破棄
  session_destroy();
  // ログインページにリダイレクト
  header('Location: Login.php');
  exit;
}