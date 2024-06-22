<?php
// ファイル名： ProcessLogin.php
// コード内容： ログイン画面（DB処理）

include_once("Pdo.php");
include_once("../components/CheckValue.php");

// ログインボタンを押したら
if (isset($_POST["loginSubmit"])) {
  // 異常入力確認
  $loginId = testInputValue($_POST["loginId"]);
  $password = testInputValue($_POST["password"]);
  try {
    // 入力されているか
    if (empty($loginId) || empty($password)) {
      setErrorMessage("ログインIDとパスワードを入力してください");
    } else {
      // 一致しているかDBと確認
      $loginSql = "SELECT user_id, password FROM Users WHERE login_id = ?";
      $stmt = $conn->prepare($loginSql);
      $stmt->bindValue(1, $loginId);
      $stmt->execute();
      
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      $verified = password_verify($password, $user['password']);
      if ($verified) {
        // ログインしているユーザIDをセンションに登録し、いいね画面に遷移する
        setUserIdSession($user['user_id']);
        header('Location: ../pages/Interactions.php');
        exit;
      } else {
        setErrorMessage("ログインIDまたはパスワードが正しくありません");
      }
    }
  } catch (PDOException $e) {
    setErrorMessage("ログインに失敗しました: " . $e->getMessage());
  }
  header("Location: ../pages/Login.php");
  exit;
}