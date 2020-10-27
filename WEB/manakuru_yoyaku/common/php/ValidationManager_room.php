<?php

function validation($data){

  $error = [];

  if(empty($data['room_name'])){
    $error[] = '部屋名を入力してください。';
  }

  if(empty($data['seat']) ){
    $error[] ='席数を入力してください。';
  }elseif(!(preg_match('/^[0-9]+$/', $data['seat']))){
    $error[] ='席数は半角数字で入力してください';
  }

  if(!isset($data['loan'])){
    $error[] = '貸出可否を選択してください。';
  }

  return $error;
}

?>