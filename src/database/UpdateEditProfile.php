<?php
// ファイル名： UpdateEditProfile.php
// コード内容： プロフィール編集画面（DBの後処理）

include_once("Pdo.php");
include_once("../components/CheckValue.php");

if (isset($_POST["editProfileSubmit"])) {
  // ユーザ名、性別と年齢が入力されているか
  $inputValue = !empty($_POST["username"]) && isset($_POST["gender"]) && 
    ($_POST["age"] !== "年齢を選択していください");
  if ($inputValue) {
    try {
      // トランザクション開始
      $conn->beginTransaction();
      // 異常入力の確認
      $username = testInputValue($_POST["username"]);
      $age = testInputValue($_POST["age"]);
      $gender = testInputValue($_POST["gender"]);
      $bloodType = testInputValue($_POST["bloodType"]);
      $location = testInputValue($_POST["location"]);
      $interests = testInputValue($_POST["interests"]);
      $description = testInputValue($_POST["description"]);
      
      // 編集したプロフィールを更新
      $updateProfileSql = 
        "UPDATE Users SET username = ?, age = ?, gender = ?, blood_type = ?, 
        location = ?, interests = ?, description = ? WHERE user_id = ?";
      $stmt = $conn->prepare($updateProfileSql);
      $stmt->bindValue(1, $username);
      $stmt->bindValue(2, $age);
      $stmt->bindValue(3, $gender);
      $stmt->bindValue(4, $bloodType);
      $stmt->bindValue(5, $location);
      $stmt->bindValue(6, $interests);
      $stmt->bindValue(7, $description);
      $stmt->bindValue(8, getUserIdSession());
      $stmt->execute();
      
      // プロフィール写真を更新しているか
      $uploadPicture = is_uploaded_file($_FILES["profilePicture"]["tmp_name"]);
      if ($uploadPicture) {
        // 画像情報を取得
        $pictureName = $_FILES["profilePicture"]["name"];
        $pictureType = $_FILES["profilePicture"]["type"];
        $pictureSize = $_FILES["profilePicture"]["size"];
        $pictureTmpName = $_FILES["profilePicture"]["tmp_name"];
        $pictureFile = file_get_contents($pictureTmpName);
        $pictureContents = base64_encode($pictureFile);
        
        $validPicType = checkPicType($pictureName);
        if ($validPicType) {
          // アップロードした画像のサイズ確認
          if ($pictureSize <= MAX_SIZE) {
            //DBを更新する 
            $updatePictureSql = 
              "UPDATE Profile_Pictures SET picture_name = ?, picture_type = ?, 
              picture_contents = ? WHERE user_id = ?";
            $stmt = $conn->prepare($updatePictureSql);
            $stmt->bindValue(1, $pictureName);
            $stmt->bindValue(2, $pictureType);
            $stmt->bindValue(3, $pictureContents);
            $stmt->bindValue(4, getUserIdSession());
            $stmt->execute();
            
            // 画像とプロフィール情報が登録成功したらコミットする
            $conn->commit();
            header("Location: ../pages/Profile.php");
            exit;
          } else {
            // サイズが1Mを超えたらロールバックする
            setErrorMessage("画像サイズが1Mを超えました");
            $conn->rollback();
          }
        } else {
          setErrorMessage("jpg、jpeg、png、gifの画像を使ってください");
          $conn->rollback();
        }
      } else {
        // プロフィール情報が登録成功したらコミットする
        $conn->commit();
        header("Location: ../pages/Profile.php");
          exit;
      }
    } catch (PDOException $e) {
      setErrorMessage("プロフィール更新失敗: " . $e->getMessage());
      // 片方失敗したらロールバックする
      $conn->rollback();
    }
  } else {
    setErrorMessage("名前、年齢、性別が必須項目です");
  }
  header("Location: ../pages/EditProfile.php");
  exit;
}