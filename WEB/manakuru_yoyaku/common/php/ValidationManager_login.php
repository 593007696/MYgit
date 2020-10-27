<?php

function validation($data){

  $error = [];

  if(empty($data['staff_id'])){
    $error[] = 'ユーザーIDを入力してください。';
  }

  if(empty($data['password'])){
    $error[] = 'パスワードを入力してください。';
  }

  return $error;
}

?>

