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

    <!--ログイン情報-->
    <div class="center">
        <?php

        //ログイン済みの場合
        session_start();

        if (!isset($_SESSION['STAFF_ID']) && !isset($_SESSION['LAST_NAME']) && !isset($_SESSION['FIRST_NAME']) && !isset($_SESSION['STORE_ID'])) {
            echo "ログインしてください。<br /><br />";
            echo '<a href="login/login.php">ログインへ</a>';
        } else {

            $now = time();

            if ($now > $_SESSION['expire']) {
                session_destroy();
                echo "一定時間で操作をしませんでした。ログインし直してください。<a href='login/login.php'>ログインへ</a>";
            } else {

                include('common/php/SessionManager.php');


        ?>
    </div>
    <h1><img src="common/img/logo3.png"></h1>
    <div class="center">
        <h2> メニュー</h2>
    </div>
    <div class="box">

        <form>



            <a href="master/store/store_list.php" style="text-decoration: none;">
                <input type="button" class="btn btn3" title="store" value="店舗マスター"></input>
            </a>
            </br>


            <a href="master/room/room_list.php" style="text-decoration: none;">
                <input type="button" class="btn btn2" title="room" value="部屋マスター"></input>
            </a>
            </br>


            <a href="master/calendar/calendar_master.php" style="text-decoration: none;">
                <input type="button" class="btn btn4" title="calendar" value="カレンダーマスター"></input>
            </a>
            </br>


            <a href="master/system_user/systemuser_list.php" style="text-decoration: none;">
                <input type="button" class="btn btn1" title="systermuser" value="システムユーザーマスター"></input>
            </a>
            </br>


            <a href="master/service/service_m_list.php" style="text-decoration: none;">
                <input type="button" class="btn btn1" title="course " value="サービスマスター"></input>
            </a>
            </br>



        </form>
    </div>
    <br>
    <div class="center">
        <a href="main.php">
            <input type="button" class="button" title="return" value="戻る"></input>
        </a>
    </div>
    <br>


</body>
<?php

            }
        }
?>
<footer> ©2020 株式会社ジェイテック</footer>

</html>