<?php

function validation($data){

  $error = [];

  if(empty($data['staff_id']) ){
    $error[] ='ユーザーIDを入力してください。';
  }elseif (strlen($data['staff_id']) > 10 ) {
    $error[] ='文字数がオーバーしています';
  }

  if(empty($data['last_name']) ){
    $error[] ='姓を入力してください。';
  }elseif (!(preg_match('/^[a-z A-Z一-龠]+$/u',$data['last_name']))){
    $error[] ='姓は漢字か半角英数で入力してください。';
  }

  if(empty($data['first_name'])){
    $error[] ='名を入力してください。';
  }elseif (!(preg_match('/^[a-z A-Z一-龠]+$/u',$data['first_name']))){
    $error[] ='名は漢字か半角英数で入力してください。';
  }


  if(empty($data['gender']) ){
    $error[] ='性別を入力してください。';
  }

  if(empty($data['B_year']) && empty($data['B_month']) && empty($data['B_day'])){
    $error[] ='生年月日を入力してください';
  }

  if(empty($data['year'])  && empty($data['month'])  && empty($data['day'])){
    $error[] ='入社日を入力してください';
  }

  if(empty($data['syozoku_store_id']) ){
    $error[] ='所属店舗を入力してください。';
  }

  if(empty($data['type_employment']) ){
    $error[] ='雇用形態を入力してください。';
  }

  if(empty($data['role']) ){
    $error[] ='役割を入力してください。';
  }

  if(!isset($data['teacher']) ){
    $error[] ='講師を入力してください。';
  }

  if(empty($data['zipcode1']) || empty($data['zipcode2'])){
    $error[] ='郵便番号を入力してください。';
  }elseif (!(preg_match('/^[0-9]+$/', $data['zipcode1']))||(!(preg_match('/^[0-9]+$/', $data['zipcode2'])))){
    $error[] ='郵便番号は半角英数で入力してください。';
  }

  if(empty($data['prefectures'])){
    $error[] ='都道府県を入力してください。';
  }

  if(empty($data['ward'])){
    $error[] ='区市町村を入力してください。';
  }

  if(empty($data['address'])){
    $error[] ='住所を入力してください。';
  }


  if(empty($data['tel'])){
    $error[] ='電話番号を入力してください。';
  }elseif (!(preg_match('/^[0-9]{10,11}+$/', $data['tel']))){
    $error[] ='電話番号は10～11桁または半角数字で入力してください。';
  }

  if(empty($data['email']) || empty($data['emailConfirm']) ){
    $error[] ='メールアドレスを入力してください。';
  }elseif (!(preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $data['email'])) || !(preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $data['emailConfirm']))){
    $error[] ='メールアドレスが不正です。';
  }elseif($data['email']!=$data['emailConfirm']){
    $error[] ='メールアドレスが一致しません。';
  }

  if(empty($data['password']) || empty($data['passwordConfirm']) ){
    $error[] ='パスワードを入力してください。';
  }elseif (!(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $data['password'])) || !(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $data['passwordConfirm']))){
    $error[] ='パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
  }elseif($data['password']!=$data['passwordConfirm']){
    $error[] ='パスワードが一致しません。';
  }

  return $error;
}

?>