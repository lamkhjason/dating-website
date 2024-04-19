<?php
    /**
     * FileName   : ⑥user_list.php
     * ScreenName : ユーザ一覧画面
     * DateTime   : 2023年6月
     */

    include("pdo.php"); // pdoファイルをインポート
    session_start();    // session開始

    // 定数を定義
    Define("LOGIN_URL","./login.php"); // ログイン画面のリンク
    Define("USER_URL","./user_list.php"); // ユーザ一覧画面のリンク

    //ログインがされていない時はログイン画面に遷移する
    try {
      D interaction_type =’yes’) AND (target_user_id = ? AND interaction_type = ‘yes’) ";  $checkSql = "SELECT username,age,gender FROM Users INNER JOIN Interactions on user_id  = user_id WHERE (user_id=? AN
        $stmt     = $pdo->prepare($checkSql);

$stmt->bindValue(1,$_SESSION["user_id"]);
$stmt->bindValue(1,$_SESSION["user_id"]);

        $stmt->execute();

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if($admin){
            $login_status = true;
        }else{
            $login_status = false;
            header("Location:".LOGIN_URL); //adminに中身がない場合、ログイン画面へ遷移
        }

    } catch (PDOException $e) {
        var_dump($e);
    }


?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <!--文字コード/ブラウザ種別対応-->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--ページタイトル-->
        <title>マッチング成功画面</title>
        <!--cssファイル読み込み-->
        <link rel="stylesheet" href="./css/CSS班が作った名前.css">　
    </head>

    <body>
        <div class="content">
             <h1>ユーザ一覧</h1>
                </div>
                    <table class="user-table">
                <?php foreach (array_reverse($data) as $user) { ?>
                        <tr>
                            
                            <td>
                                <a href ="/profile.php?user_id=<?php echo $user["username"]?>"> 
                                    <p>
                                        <?php
                                            echo htmlspecialchars($user["age"], ENT_QUOTES, "UTF-8");
                                        ?>
                                    </p>
                                      <p>
                                        <?php
                                            echo htmlspecialchars($user["gender"], ENT_QUOTES, "UTF-8");
                                        ?>
                                    </p>
                                      <p>
                                        <?php if (!empty($user["description"])) {
                                            echo htmlspecialchars($user["description"], ENT_QUOTES, "UTF-8");
                                        ?>
                                    </p>
　　　　　　　　　　　　　　　　　　　　　　　　　　　<form action="ここはもう少し実装方法考えます　ボタンじゃない方法など" method="post">
       　　　　　　　　　　　　　　　　　　　　　　　　　 <button type="submit">遷移ボタン</button>
                       
                                </a>       
                            </td>
                    </table>
              
                </div>
        </div>
    </body>
</html>
