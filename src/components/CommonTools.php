<?php
// ファイル名： CommonTool.php
// コード内容： 各画面の共通部分（header）

define("SYSTEM_NAME", "/dating-website/src");
// メニューバーの連想配列
$menubar = [
  "マッチング一覧" => SYSTEM_NAME . "/pages/MatchedList.php",
  "いいね" => SYSTEM_NAME . "/pages/Interactions.php",
  "プロフィール" => SYSTEM_NAME . "/pages/Profile.php",
];

function checkActivePage($directory) {
  if ($directory === $_SERVER["SCRIPT_NAME"] && !isset($_GET["targetUserId"])) {
    return ":active"; // 表示している画面をactiveモードにする
  }
}
?>
<header class="top-bar">
  <div class="system-icon"><i class="bi-calendar-heart-fill"></i></div>
  <?php 
  // ログイン画面と新規登録画面以外、メニューバーとログアウトボタンを表示する
  $showMenubar = 
    $_SERVER["SCRIPT_NAME"] === $menubar['いいね'] || 
    $_SERVER["SCRIPT_NAME"] === $menubar['プロフィール'] ||
    $_SERVER["SCRIPT_NAME"] === $menubar['マッチング一覧'];
  if ($showMenubar):
  ?>
    <nav class="nav-btn-group">
      <?php 
      include_once("../database/LoginStatus.php");
      foreach ($menubar as $title => $directory) {
        $activeMode = checkActivePage($directory);
        echo "<a href='$directory' class='nav-btn' $activeMode>$title</a>";
      }
      ?>
    </nav>
    <form method="POST" class="logout-icon">
      <input type="hidden" name="logoutSubmit">
      <i 
        class="bi-box-arrow-right" 
        onclick="this.parentNode.submit()" 
      ></i>
    </form>
  <?php endif; ?>
</header>