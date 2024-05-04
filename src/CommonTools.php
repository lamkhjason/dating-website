<?php
$menubar = [
  "マッチング一覧" => "/dating-website/src/MatchedList.php",
  "いいね" => "/dating-website/src/Interactions.php",
  "プロフィール" => "/dating-website/src/Profile.php",
];

function checkActivePage($directory) {
  if ($directory === $_SERVER["SCRIPT_NAME"] && !isset($_GET["targetUserId"])) {
    $mode = "btn btn-outline-light active mt-2";
  } else {
    $mode = "btn btn-outline-light mt-2";
  }
  return $mode;
}
?>

<header class="sticky-top container-fluid bg-info p-2">
  <div class="row justify-content-around">
    <div class="col-auto m-0">
      <i class="bi-calendar-heart-fill text-light" style="font-size: 35px;"></i>
    </div>
    <?php 
    $showMenubar = 
      $_SERVER["SCRIPT_NAME"] !== "/dating-website/src/Login.php" && 
      $_SERVER["SCRIPT_NAME"] !== "/dating-website/src/Register.php";
    if ($showMenubar):
    ?>
      <nav class="col-9 m-0">
        <div class="btn-group container">
          <?php 
          include_once("LoginStatus.php");
          foreach ($menubar as $title => $directory) {
            $btnClass = checkActivePage($directory);
            echo "<a href='$directory' class='$btnClass'>$title</a>";
          }
          ?>
        </div>
      </nav>
      <div class="col-auto m-0">
        <form method="POST" action="<?php $_SERVER["SCRIPT_NAME"];?>">
          <input type="hidden" name="logoutSubmit">
            <i 
              class="bi-box-arrow-right text-light" 
              onclick="this.parentNode.submit()" 
              style="cursor: pointer; font-size: 35px;"
            ></i>
        </form>
      </div>
    <?php endif; ?>
  </div>
</header>