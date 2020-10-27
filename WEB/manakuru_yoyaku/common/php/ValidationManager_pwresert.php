<?php

function validation($data){

  $error = [];

  if(empty($data['staff_id'])){
    $error[] = 'ユーザーIDを入力してください。';
  }

  if(empty($data['last_name'])){
    $error[] = '姓を入力してください。';
  }

  if(empty($data['first_name'])){
    $error[] = '名を入力してください。';
  }

  if(empty($data['new_password']) || empty($data['confirm_password']) ){
    $error[] ='新しいパスワードを入力してください。';
  }elseif (!(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $data['new_password'])) || !(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $data['confirm_password']))){
    $error[] ='パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
  }elseif($data['new_password']!=$data['confirm_password']){
    $error[] ='パスワードが一致しません。';
  }
  
  return $error;
}

?>
