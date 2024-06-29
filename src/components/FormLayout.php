<?php
function agePulldown($age) {
  echo "<select class='age-select' name='age'>";
  echo "<option>年齢を選択してください</option>";
  for ($ageRange = 18; $ageRange <= 100; $ageRange++) {
    $ageRange == $age ? $selected = "selected" : $selected = "";
    echo "<option $selected value='$ageRange'>$ageRange</option>";
  }
  echo "</select>";
}

function genderRadioBtn($gender) {
  $genderType = ["male" => "男性", "female" => "女性"];
  echo "<div class='gender-btn-group'>";
  foreach ($genderType as $genderId => $genderValue) {
    $gender === $genderValue ? $status = "checked" : $status = "";
    echo "<input type='radio' class='btn-check' name='gender' 
      id='$genderId' value='$genderValue' $status>";
    echo "<label class='gender-btn' for='$genderId'>$genderValue</label>";
  }
  echo "</div>";
}

function inputField($key, $title, $value) {
  if ($key === "interests" || $key === "description") {
    echo "<textarea class='input-area' name='$key'
      placeholder='" . $title . "を入力しくてださい'>$value</textarea>";
  } else {
    $key === "password" ? $type = $key : $type = "text";
    echo "<input type='$type' class='input-area' name='$key' value='$value'
      placeholder='" . $title . "を入力しくてださい'>";
  }
  echo "</div>";
}