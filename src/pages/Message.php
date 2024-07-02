<?php 
// ファイル名： Message.php
// コード内容： メッセージ画面（html部分）
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../assets/icon/calendar-heart-fill.svg">
    <link rel="stylesheet" href="../assets/css/Style.css">
    <title>メッセージ</title>
  </head>
  <body>
    <?php 
    include_once("../components/CheckValue.php");
    include_once("../database/SelectMessage.php");
    include_once("../components/CommonTools.php");
    ?>
    <main class="main-content">
      <div class="message-card">
        <div class="message-header">
          <a href="MatchedList.php" class="return-list-btn">＜ 戻る</a>
          <a 
            href="Profile.php?targetUserId=<?php echo $messageUserId; ?>"
            class="message-name-btn"><?php echo $username; ?>
          </a>
          <img 
            <?php echo "src='data: $pictureType; base64, $pictureContents'"; ?>
            class='message-pic'
          >
        </div>
        <div class="message-body">
          <div class="error-message"><?php displayErrorMessage();?></div>
          <?php 
          foreach ($message as $users) {
            if ($users["sender_id"] === getUserIdSession()) $class = "send-area";
            elseif ($users["sender_id"] == $messageUserId) $class = "receive-area";
            
            $messageContent = testInputValue($users["message_content"]);
            $picContents = testInputValue($users["picture_contents"]);
            $picType = testInputValue($users["picture_type"]);
            
            echo 
              "<div class='$class'>
                <img src='data: $picType; base64, $picContents' class='message-pic'>
                <div class='message-text'>$messageContent</div>
              </div>";
          }
          ?>
        </div>
        <div class="message-footer">
          <form method="POST" action="../database/SendMessage.php" class="message-input-group">
            <input type="hidden" name="messageUserId" value="<?php echo $messageUserId; ?>">
            <input 
              type="text" class="message-input-area" 
              name="message" placeholder="メッセージを入力してくだい"
            >
            <button type="submit" name="sendMessage" value="sent" class="send-btn">
              <i class="bi bi-send-fill"> 送信</i>
            </button>
          </form>
        </div>
      </div>
    </main>
  </body>
</html>