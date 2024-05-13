<!-- 
  ファイル名： CommonTool.php
  コード内容： 各画面の共通部分（header）
-->
<?php
// メニューバーの連想配列
$menubar = [
  "マッチング一覧" => "/dating-website/src/pages/MatchedList.php",
  "いいね" => "/dating-website/src/pages/Interactions.php",
  "プロフィール" => "/dating-website/src/pages/Profile.php",
];

function checkActivePage($directory) {
  if ($directory === $_SERVER["SCRIPT_NAME"] && !isset($_GET["targetUserId"])) {
    $mode = "btn btn-outline-light active my-2"; // 表示している画面のクラス
  } else {
    $mode = "btn btn-outline-light my-2"; // 表示している画面以外のクラス
  }
  return $mode;
}
?>
<script src="../js/Congratulations.js"></script>
<header class="top-bar">
  <div class="col-auto">
    <i class="bi-calendar-heart-fill text-light" style="font-size: 35px;"></i>
  </div>
  <?php 
  // ログイン画面と新規登録画面以外、メニューバーとログアウトボタンを表示する
  $showMenubar = 
    $_SERVER["SCRIPT_NAME"] !== "/dating-website/src/pages/Login.php" && 
    $_SERVER["SCRIPT_NAME"] !== "/dating-website/src/pages/Register.php";
  if ($showMenubar):
  ?>
    <nav class="col-9 btn-group">
      <?php 
      include_once("../database/LoginStatus.php");
      foreach ($menubar as $title => $directory) {
        $btnClass = checkActivePage($directory);
        echo "<a href='$directory' class='$btnClass'>$title</a>";
      }
      ?>
    </nav>
    <form method="POST" class="col-auto">
      <input type="hidden" name="logoutSubmit">
      <i 
        class="bi-box-arrow-right text-light" 
        onclick="this.parentNode.submit()" 
        style="cursor: pointer; font-size: 35px;"
      ></i>
    </form>
  <?php endif; ?>
</header>