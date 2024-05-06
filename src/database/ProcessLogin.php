<?php
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
      $loginSql = "SELECT user_id FROM Users WHERE login_id = ? AND password = ?";
      $stmt = $conn->prepare($loginSql);
      $stmt->bindValue(1, $loginId);
      $stmt->bindValue(2, $password);
      $stmt->execute();
      
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if (!empty($user)) {
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