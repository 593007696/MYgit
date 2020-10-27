<?php
function GetDb(){
  $DNS ='mysql:dbname=manakuru;host=localhost;charset=utf8';
  $DB_USER = 'manakuru_0401';
  $DB_PASSWORD = 'yoyaku_20200401';
 
    try {
      $pdo =  new PDO( $DNS, $DB_USER, $DB_PASSWORD);
      $pdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//エラーモードの設定   
    } catch (Exception $e) {
      echo 'エラーが発生しました。:' . $e->getMessage();
  }
    return $pdo;
}

?>