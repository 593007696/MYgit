<?php
session_start();

if (isset($_SESSION['LAST_NAME']) && isset($_SESSION['FIRST_NAME'])) {
  $alert = "<script type='text/javascript'>alert('ログアウトしました');</script>";
  echo $alert;
  header('location:login.php');
} else {
  echo '一定時間で操作をしませんでした。ログインし直してください。';
}
//セッション変数のクリア
$_SESSION = array();
//セッションクッキーも削除
if (ini_get("session.use_cookies")) {
  setcookie(session_name(), '', time() - 42000, '/');
}
//セッションクリア
@session_destroy();
?>

