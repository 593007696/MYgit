<?php

function validation($data){

  $error = [];

  if(empty($data['store_name'])){
    $error[] = '店舗名を入力してください。';
  }

  if(empty($data['zipcode1']) || empty($data['zipcode2'])){
    $error[] = '郵便番号を入力してください。';
  }elseif (!(preg_match('/^[0-9]+$/', $data['zipcode1']))||(!(preg_match('/^[0-9]+$/', $data['zipcode2'])))){
    $error[] ='郵便番号は半角数字で入力してください。';
  }

  if(empty($data['prefectures']) ){
    $error[] ='都道府県を入力してください。';
  }

  if(empty($data['ward']) ){
    $error[] ='区/市/町/村を入力してください。';
  }
  
  if(empty($data['address']) ){
    $error[] ='住所を入力してください。';
  }

  if(empty($data['tel'])){
    $error[] ='電話番号を入力してください。';
  }elseif (!(preg_match('/^[0-9]{10,11}+$/', $data['tel']))){
    $error[] ='電話番号は10～11桁または半角数字で入力してください。';
  }

  if (empty($data['fax'])){
    $error[] ='fax番号を入力してください。';
  }elseif (!(preg_match('/^[0-9]{10,11}+$/', $data['fax']))){
    $error[] ='FAX番号は10～11桁または半角数字で入力してください。';
  }
  
  return $error;
}

?>