<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>サービスカレンダー</title>
    <script type="text/javascript" src="js/security_lock .js"></script>

    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/checkbox.css" type="text/css">
    <h1><img src="img/logo3.png"></h1>
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
</head>




<!--ログイン情報-->
<div>
    <?php
    //ログイン済みの場合
    session_cache_limiter('none');
    session_start();

    if (!isset($_SESSION['STAFF_ID']) && !isset($_SESSION['LAST_NAME']) && !isset($_SESSION['FIRST_NAME']) && !isset($_SESSION['STORE_ID'])) {
        echo "ログインしてください。<br /><br />";
        echo '<a href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/login.php">ログインへ</a>';
    } else {

        $now = time();

        if ($now > $_SESSION['expire']) {
            session_destroy();
            echo "一定時間で操作をしませんでした。ログインし直してください。<a href='http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/login.php'>ログインへ</a>";
        } else {

            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/SessionManager.php');


    ?>
</div>




<body>

    <?php
            //クリックジャッキング防止
            header('X-Frame-Options:Deny');

            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

            $pdo = GetDb();

            $store_id = $_GET['store_id'];
    ?>

    <div class="center">
        <h2>サービスカレンダー</h2>


        <?php

            //年算出
            if (isset($_GET['year'])) {
                $year = $_GET['year'];
            } else {
                $year = date('Y');
            }
            //日算出
            $day    = date('d');
            if (isset($_GET['month'])) {
                $month = $_GET['month'];
                //月算出
                $now_num = strtotime(date("$year-$month-$day"));
            } else {
                $now_num = strtotime('now');
                $month = date('n', $now_num);
            };


            $weekArr = array("日", "月", "火", "水", "木", "金", "土");


            //今月何日ある
            $month_max_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            //$month_max_day = date("t", mktime(0, 0, 0, $month, 1, $year));

            //今年2月何日ある
            $February_max_day = cal_days_in_month(CAL_GREGORIAN, 2, $year);
            //今年何日ある
            $year_max_day = 337 + $February_max_day;
            //先月は何月
            $last_month = date('n', $now_num - $month_max_day * 24 * 60 * 60);
            //来月は何月
            $next_month = date('n', $now_num + $month_max_day * 24 * 60 * 60);
            //前年と来年算出
            if ($month == 12 || $next_month == 1) {
                $next_year = date('Y', $now_num + $year_max_day * 24 * 60 * 60);
                $last_year = $year;
            } elseif ($month == 1 || $last_month == 12) {
                $last_year = date('Y', $now_num - $year_max_day * 24 * 60 * 60);
                $next_year = $year;
            } else {
                $next_year = $year;
                $last_year = $year;
            }

            echo "<h3>" . $year . "年" . $month . "月" . "</h3>";
        ?>
    </div>
    <form action="service_list.php" method="post">

        <?php
            echo '<input type="hidden"name="tid"value="' . $store_id . '">';
        ?>

        <input class="button" type="submit" value="戻る">
    </form>
    <br>
    <?php

            //印刷

            echo "<table class='zebra' style='height:100%;'>";
            echo "<tr>";
            echo "
                    <td rowspan='$month_max_day'style='height:100%; width:5%;'>
                    <a href = 'service_calendar.php?month=$last_month&year=$last_year&store_id=$store_id'>
                    <button title='先月' style='height:100%; width:100%;'><img src='img/left.png'></button>
                    </a>
                    </td>";

            for ($i = 1; $i <= $month_max_day; $i++) {
                $hituke = "$year" . "-" . "$month" . "-" . "$i";
                //$day_num = strtotime(date("$year-$month-$i"));
                $day_num = strtotime(date(" $hituke"));
                $week_num = date("w", $day_num);
                $week = $weekArr[$week_num];
                //サービスデータ獲得
                $sql = "SELECT *  FROM `t_service_set_detail` 
                        WHERE `store_id` = :store_id
                        AND `service_day_detail` = :hituke
                        ORDER BY `start_time_detail` ASC 
                        ";

                $service_detail_date = $pdo->prepare($sql);
                $service_detail_date->bindParam(':store_id', $store_id);
                $service_detail_date->bindParam(':hituke', $hituke);
                $service_detail_date->execute();

                echo "
                    <th>$i ($week)</th>
                    <td  style='width:80%;'>";

                while ($row = $service_detail_date->fetch(PDO::FETCH_ASSOC)) {
                    if (isset($row)) {

                        $start_time_detail = $row['start_time_detail'];
                        $start_time_detail = date("G:i", strtotime($start_time_detail));

                        $end_time_detail = $row['end_time_detail'];
                        $end_time_detail = date("G:i", strtotime($end_time_detail));

                        $time = $start_time_detail . "~" . $end_time_detail;

                        //ID獲得
                        $service_start_id = $row['service_start_id'];
                        $sql = "SELECT *  FROM `t_service_set` 
                                WHERE `store_id` = :store_id
                                AND `service_start_id` = :service_start_id
                                ";
                        $service_set_date = $pdo->prepare($sql);
                        $service_set_date->bindParam(':store_id', $store_id);
                        $service_set_date->bindParam(':service_start_id', $service_start_id);
                        $service_set_date->execute();

                        $get_id = $service_set_date->fetch(PDO::FETCH_ASSOC);
                        $service_id = $get_id['service_id'];
                        $room_id = $get_id['room_id'];

                        //サービス名獲得
                        $sql = "SELECT *  FROM `m_service` 
                                WHERE `store_id` = :store_id
                                AND `service_id` = :service_id
                                ";
                        $service_date = $pdo->prepare($sql);
                        $service_date->bindParam(':store_id', $store_id);
                        $service_date->bindParam(':service_id', $service_id);
                        $service_date->execute();

                        $get_service = $service_date->fetch(PDO::FETCH_ASSOC);
                        $service_name = $get_service['service_name'];
                        $service_titile = $get_service['service_title'];
                        $service_course = "$service_name" . "<br>" . "$service_titile";
                        $service_flg    = $get_service['service_flg'];

                        //部屋名獲得
                        $sql = "SELECT * FROM `m_room` 
                                WHERE `store_id`= :store_id 
                                AND`room_id`= :room_id";
                        $room_date = $pdo->prepare($sql);
                        $room_date->bindParam(':store_id', $store_id);
                        $room_date->bindParam(':room_id', $room_id);
                        $room_date->execute();

                        $get_room    = $room_date->fetch(PDO::FETCH_ASSOC);
                        $room_name    = $get_room['room_name'];
                    } else {
                        $service_course = "";
                        $time = "";
                        $room_name    = "";
                    }

                    if ($service_flg == "1") {
                        $color = "blue";
                    } else {
                        $color = "red";
                    }

                    echo "<font color=$color>" . $time . "</font>" . "<br>|" . $room_name . "|" . "<br>" . $service_course . "<hr>";
                };

                echo "</td>";

                if ($i == 1) {
                    echo "
                        <td rowspan='$month_max_day' style='height:100%; width:5%;'>
                        <a href = 'service_calendar.php?month=$next_month&year=$next_year&store_id=$store_id'>
                        <button title='来月' style='height:100%; width:100%;'><img src='img/right.png'></button>
                        </a>
                        </td>
                        ";
                }
                echo "<tr>";
            }

            echo "</table>";
            $pdo = null;
    ?>

<?php

        }
    }
?>
</body>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>