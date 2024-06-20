<?php
// ファイル名： ProcessProfilePic.php
// コード内容： プロフィール写真編集画面（DBに登録/追加/削除）

include_once("Pdo.php");
include_once("../components/CheckValue.php");

if (isset($_POST["editProfilePicSubmit"])) {
  try {
    $conn->beginTransaction();
    for ($index = 1; $index <= MAX_PIC; $index++) {
      $pic = "Pic_$index";
      $id = "PicId_$index";
      if (is_uploaded_file($_FILES[$pic]["tmp_name"])) {
        $name = $_FILES[$pic]["name"];
        $type = $_FILES[$pic]["type"];
        $size = $_FILES[$pic]["size"];
        $tmpName = $_FILES[$pic]["tmp_name"];
        $picFile = file_get_contents($tmpName);
        $picContents = base64_encode($picFile);
        
        if ($size <= MAX_SIZE) {
          if (!empty($_POST[$id])) {
            $picId = $_POST[$id];
            $updatePicSql = 
              "UPDATE Profile_Pictures SET picture_name = ?, picture_type = ?, 
              picture_contents = ? WHERE user_id = ? AND picture_id = ?";
            $stmt = $conn->prepare($updatePicSql);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $type);
            $stmt->bindValue(3, $picContents);
            $stmt->bindValue(4, getUserIdSession());
            $stmt->bindValue(5, $picId);
            $stmt->execute();
          } else {
            $uploadPicSql = 
              "INSERT INTO Profile_Pictures (user_id, picture_name, 
              picture_type, picture_contents) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($uploadPicSql);
            $stmt->bindValue(1, getUserIdSession());
            $stmt->bindValue(2, $name);
            $stmt->bindValue(3, $type);
            $stmt->bindValue(4, $picContents);
            $stmt->execute();
          }
        } else {
          setErrorMessage("画像サイズが1Mを超えました");
          $conn->rollback();
          header("Location: ../pages/EditProfilePic.php");
          exit;
        }
      }
    }
    $conn->commit();
  } catch (PDOException $e) {
    setErrorMessage("更新失敗: " . $e->getMessage());
    $conn->rollback();
    header("Location: ../pages/EditProfilePic.php");
    exit;
  }
  header("Location: ../pages/Profile.php");
  exit;
}

if (isset($_POST["delPicSubmit"])) {
  $uploadedPic = $_POST["uploadedPic"];
  try {
    if ($uploadedPic > 1) {
      $index = $_POST["delPicSubmit"];
      $deletePicSql = "DELETE FROM Profile_Pictures WHERE picture_id = ?";
      $stmt = $conn->prepare($deletePicSql);
      $stmt->bindValue(1, $_POST["PicId_$index"]);
      $stmt->execute();
    } else {
      setErrorMessage("最低写真1枚が必須です");
    }
  } catch (PDOException $e) {
    setErrorMessage("削除失敗: " . $e->getMessage());
  }
  header("Location: ../pages/EditProfilePic.php");
  exit;
}