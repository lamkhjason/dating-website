<?php 
session_start();

//画像をDBに格納できる最大のサイズの定数
define("MAX_SIZE", 1048576);

//異常入出力の確認
function testInputValue($data) {
  return htmlspecialchars($data, ENT_QUOTES, "UTF-8");
}

//プロフィール項目が入力されているかの確認
function checkProfileItem($data) {
  if (empty($data)) {
    $data = "記入なし";
  }
  return testInputValue($data);
}

//ログインIDセッションを設定する
function setUserIdSession($userId) {
  $_SESSION["userId"] = $userId;
}

//ログインIDセッションを返す
function getUserIdSession() {
  return $_SESSION["userId"];
}
