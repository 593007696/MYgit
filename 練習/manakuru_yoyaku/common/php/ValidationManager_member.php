<?php

function validation($data){

  $error = [];
  
  if(empty($data['store_id']) ){
    $error[] ='店舗IDは必ず入力してください。';
  }elseif (!(preg_match('/^[0-9]+$/', $data['store_id']))) {
    $error[] ='店舗IDは半角英数で入力してください。';
  }

  if(empty($data['last_name']) || empty($data['first_name'])){
    $error[] ='姓または名は必ず入力してください。';
  }elseif (!(preg_match('/^[A-Z一-龠]+$/u',$data['last_name']))||(!(preg_match('/^[A-Z一-龠]+$/u',$data['first_name'])))){
    $error[] ='姓または名は漢字か半角英数で入力してください。';
  }

  if(empty($data['sei']) || empty($data['mei'])){
    $error[] ='セイまたはメイカタカナは必ず入力してください。';
  }elseif (!(preg_match('/^[ア-ン゛゜ァ-ォャ-ョー「」、]+$/u',$data['sei']))||(!(preg_match('/^[ア-ン゛゜ァ-ォャ-ョー「」、]+$/u',$data['mei'])))){
    $error[] ='セイまたはメイはカタカナで入力してください。';
  }

  if(empty($data['gender']) ){
    $error[] ='性別は必ず入力してください。';
  }

  if(empty($data['year']) || empty($data['month']) || empty($data['date'])){
    $error[] ='生年月日は必ず入力してください。';
  }

  if(empty($data['zipcode1']) || empty($data['zipcode2'])){
    $error[] ='郵便番号は必ず入力してください。';
  }elseif (!(preg_match('/^[0-9]+$/', $data['zipcode1']))||(!(preg_match('/^[0-9]+$/', $data['zipcode2'])))){
    $error[] ='郵便番号は半角英数で入力してください。';
  }

  if(empty($data['prefectures'])){
    $error[] ='都道府県は必ず入力してください。';
  }

  if(empty($data['ward'])){
    $error[] ='区市町村は必ず入力してください。';
  }

  if(empty($data['address'])){
    $error[] ='住所は必ず入力してください。';
  }

  if(empty($data['tel'])){
    $error[] ='電話番号は必ず入力してください。';
  }elseif (!(preg_match('/^[0-9]+$/', $data['tel']))){
    $error[] ='電話番号は半角英数で入力してください。';
  }

  if(empty($data['job'])){
    $error[] ='職業は必ず入力してください。';
  }

  if(empty($data['email'])){
    $error[] ='メールアドレスは必ず入力してください。';
  }elseif (!(preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $data['email']))){
    $error[] ='メールアドレスが不正です。';
  }

  if(empty($data['password1']) || empty($data['password2']) ){
    $error[] ='パスワードは必ず入力してください。';
  }elseif (!(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $data['password1'])) || !(preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $data['password2']))){
    $error[] ='パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
  }elseif($data['password1']!=$data['password2']){
    $error[] ='パスワードが一致しません。';
  }

  return $error;
}

?>