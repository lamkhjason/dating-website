<?php
/**
 * FileName   : MatchedList.php
 * ScreenName : マッチング一覧画面
 * DateTime   : 2024年4月
 */


include("pdo.php"); // pdoファイルをインポート
include("CommonTools.php"); // CommonToolsファイルをインポート
include("LoginStatus.php"); // LoginStatusファイルをインポート


session_start(); // session開始


// 定数を定義
define("LOGIN_URL", "./login.php"); // ログイン画面のリンク
define("USER_URL", "./user_list.php"); // ユーザ一覧画面のリンク


// ログインがされていない時はログイン画面に遷移する
$checkSql = "SELECT username,age,gender FROM Users INNER JOIN Interactions on user_id  = user_id WHERE (user_id=? AND interaction_type =’yes’) AND (target_user_id = ? AND interaction_type = ‘yes’)";
    $stmt  = $pdo->prepare($checkSql);
 
    $stmt->bindValue(1, $_SESSION["user_id"]); // 自分がいいねした相手
    $stmt->bindValue(2, $_SESSION["user_id"]); // 相手が自分にいいねした相手

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マッチング成功画面</title>
    <link rel="stylesheet" href="./css/CSS班が作った名前.css">
</head>
<body>
    <div class="content">
        <h1>ユーザ一覧</h1>
        <table class="user-table">
            <?php foreach ($data as $user): ?>
                <tr>
                    <td>
                        <p><?php echo htmlspecialchars($user["age"], ENT_QUOTES, "UTF-8"); ?></p>
                        <p><?php echo htmlspecialchars($user["gender"], ENT_QUOTES, "UTF-8"); ?></p>
                        <!--NULLじゃなかったら -->
                        <p><?php if (!empty($user["description"])) {
                            echo htmlspecialchars($user["description"], ENT_QUOTES, "UTF-8");
                        } ?></p>
                        <!-- プロフィールへのリンク -->
                        <form action="./profile.php" method="get">
                            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            <button type="submit">プロフィールを見る</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>



