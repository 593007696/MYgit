<?php
$servername = "localhost";
$username = "manakuru_0401";
$password = "yoyaku_20200401";
$dbname = "manakuru";

define("servername", $servername);
define("username", $username);
define("password", $password);
define("dbname", $dbname);

// 接続
$link = mysqli_connect(servername, username, password, dbname);
mysqli_set_charset($link, "utf8");

// 接続チェック
if (!$link) {
    exit('接続失敗 : mysqli_connect : ' . mysqli_connect_error());
}

?>