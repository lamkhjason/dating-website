<?php 
// ファイル名： CheckValue.php
// コード内容： 各画面の変数チェック、セッションの管理

session_start();

// 画像をDBに格納できる最大のサイズの定数
define("MAX_SIZE", 1048576);

//異常入出力の確認
function testInputValue($data) {
  return htmlspecialchars($data, ENT_QUOTES, "UTF-8");
}

// プロフィール項目が入力されているかの確認
function checkProfileItem($data) {
  if (empty($data)) {
    $data = "記入なし";
  }
  return $data;
}

// ログインIDのセッションを設定する
function setUserIdSession($userId) {
  $_SESSION["userId"] = $userId;
}

// セッションに保管されているログインIDを返す
function getUserIdSession() {
  return $_SESSION["userId"];
}

// エラーメッセージをセッションに保管
function setErrorMessage($message) {
  $_SESSION["error_message"] = $message;
}

function displayErrorMessage() {
  if (isset($_SESSION["error_message"])) {
    // エラーメッセージを表示する
    echo $_SESSION["error_message"];
    // エラーメッセージのセッションを解除する
    unset($_SESSION["error_message"]);
  }
}

// マッチ成立したユーザIDをセッションに保管
function setMatchedUserSession() {
  $_SESSION["matched"] = true; 
}

// マッチ成立の確認
function getMatchedUserSession() {
  if (isset($_SESSION["matched"])) {
    $matched = true;
    unset($_SESSION["matched"]);
  } else {
    $matched = false;
  }
  return $matched;
}