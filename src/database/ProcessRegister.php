<?php
// ファイル名： ProcessRegister.php
// コード内容： 新規登録画面（DB処理）

include_once("Pdo.php"); // Pdo.phpをインポート
include_once("../components/CheckValue.php"); // CheckValue.phpをインポート

// 新規登録ボタンが押された場合
if (isset($_POST["registerUserSubmit"])) {
  // 異常入力確認
  $loginId = testInputValue($_POST["loginId"]);
  $userPass = testInputValue($_POST["password"]);
  $userName = testInputValue($_POST["userName"]);
  $age = testInputValue($_POST["age"]);
  $gender = testInputValue($_POST["gender"]);
  
  // 入力値のチェックと画像のアップロードチェック
  $inputValue = empty($loginId) || empty($userPass) || empty($userName) || 
  $age === "年齢を選択してください" || empty($gender) || 
  !is_uploaded_file($_FILES["profilePicture"]["tmp_name"]);
  if ($inputValue) {
    setErrorMessage("全項目を入力してください");
  } else {
    // アップロードした画像のサイズ確認
    $validPicType = checkPicType($_FILES["profilePicture"]["name"]);
    if ($validPicType) {
      if ($_FILES["profilePicture"]["size"] > MAX_SIZE) {
        setErrorMessage("画像サイズが1Mを超えました");
      } else {
        try {
          // loginIdが一意か確認
          $checkUserSql = "SELECT login_id FROM Users WHERE login_id = ?";
          $stmt = $conn->prepare($checkUserSql);
          $stmt->bindValue(1, $loginId);
          $stmt->execute();
          
          $user = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
          setErrorMessage("新規登録に失敗しました" . $e->getMessage());
        }
        if (empty($user)) {
          $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/";
          $validPw = preg_match($pattern, $userPass);
          if ($validPw) {
            try {
              // トランザクション開始
              $conn->beginTransaction();
              // プロフィール情報をDBに登録
              $registerSql = 
                "INSERT INTO Users (login_id, password, username, gender, age) 
                VALUES (?, ?, ?, ?, ?)";
              $stmt = $conn->prepare($registerSql);
              $stmt->bindValue(1, $loginId);
              $stmt->bindValue(2, $userPass);
              $stmt->bindValue(3, $userName);
              $stmt->bindValue(4, $gender);
              $stmt->bindValue(5, $age);
              $stmt->execute();
              
              // DBに登録されたuser_idを取得
              $lastInsertId = $conn->lastInsertId();
              
              // 画像情報を取得し、DBに登録
              $pictureName = $_FILES["profilePicture"]["name"]; // 画像名を取得
              $pictureType = $_FILES["profilePicture"]["type"]; // 画像拡張子を取得
              $pictureTmpName = $_FILES["profilePicture"]["tmp_name"];
              $pictureFile = file_get_contents($pictureTmpName); // 画像のデータを取得
              $pictureContents = base64_encode($pictureFile); // 画像をエンコード
              
              $uploadPictureSql = 
                "INSERT INTO Profile_Pictures (user_id, picture_name, 
                picture_type, picture_contents) VALUES (?, ?, ?, ?)";
              $stmt = $conn->prepare($uploadPictureSql);
              $stmt->bindValue(1, $lastInsertId);
              $stmt->bindValue(2, $pictureName);
              $stmt->bindValue(3, $pictureType);
              $stmt->bindValue(4, $pictureContents);
              $stmt->execute();
              
              // 画像とプロフィール情報が登録成功したらコミットする
              $conn->commit();
              header("Location: ../pages/Login.php");
              exit();
            } catch (PDOException $e) {
              setErrorMessage("新規登録に失敗しました" . $e->getMessage());
              // 片方失敗したらロールバックする
              $conn->rollback();
            }
          } else {
            setErrorMessage("有効なパスワードではありません");
          }
        } else {
          setErrorMessage("既に使用されているログインIDです");
        }
      }
    } else {
      setErrorMessage("jpg、jpeg、png、gifの画像を使ってください");
    }
  }
  header("Location: ../pages/Register.php");
  exit();
}