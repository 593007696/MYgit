<!DOCTYPE html>
<html>

<head>
    <title>まなクル</title>
    <link rel="stylesheet" href="common/css/style.css" type="text/css">
    <link rel="stylesheet" href="common/css/buton.css" type="text/css">
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />

</head>



<body>

    </br>

    <!--ログイン情報-->
    <div class="center">
        <?php

        //ログイン済みの場合
        session_start();

        if (!isset($_SESSION['STAFF_ID']) && !isset($_SESSION['LAST_NAME']) && !isset($_SESSION['FIRST_NAME']) && !isset($_SESSION['STORE_ID'])) {
            echo "ログインしてください。<br><br>";
            echo '<a href="login/login.php">ログインへ</a>';
        } else {

            $now = time();

            if ($now > $_SESSION['expire']) {
                session_destroy();
                echo "一定時間で操作をしませんでした。ログインし直してください。<br><a href='login/login.php'>ログインへ</a>";
            } else {

                include('common/php/SessionManager.php');


        ?>
    </div>
    <h1><img src="common/img/logo3.png"></h1>
    <div class="center">
        <h2>メインメニュー </h2>
    </div>
    <div class="box">

        <br><br>

        <a href="t_member_service/member_service.php" style="text-decoration: none;">
            <input type="button" class="btn btn1" title="customr_register " value="予約受付"></input>
        </a>
        </br>

        <a href="member/member_list.php" style="text-decoration: none;">
            <input type="button" class="btn btn2" title="staf_register " value="会員データ"></input>
        </a>
        </br>

        <a href="t_service/service_list.php" style="text-decoration: none;">
            <input type="button" class="btn btn3" title="cours_redister " value="サービス設定"></input>
        </a>
        </br>

        <a href="menu.php" style="text-decoration: none;">
            <input type="button" class="btn btn4" title="room_redister " value="マスター登録"></input>
        </a>
        </br>

    </div>
    <br>

</body>
<?php

            }
        }
?>

<footer> ©2020 株式会社ジェイテック</footer>


</html>