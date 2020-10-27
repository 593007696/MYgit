<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <title>サービス詳細一覧</title>
    <script type="text/javascript" src="js/security_lock .js"></script>

    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/checkbox.css" type="text/css">
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
</head>




<!--ログイン情報-->
<div class="center">
    <?php
    //ログイン済みの場合
    session_cache_limiter('none');
    session_start();

    if (!isset($_SESSION['STAFF_ID']) && !isset($_SESSION['LAST_NAME']) && !isset($_SESSION['FIRST_NAME']) && !isset($_SESSION['STORE_ID'])) {
        echo "ログインしてください。<br><br>";
        echo '<a href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/login.php">ログインへ</a>';
    } else {

        $now = time();

        if ($now > $_SESSION['expire']) {
            session_destroy();
            echo "一定時間で操作をしませんでした。ログインし直してください。<br><a href='http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/login.php'>ログインへ</a>";
        } else {

            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/SessionManager.php');


    ?>
</div>

<h1><img src="img/logo3.png"></h1>



<body>
    <div class="center">
        <h2>サービス詳細一覧</h2>
    </div>




    <?php

            //クリックジャッキング防止
            header('X-Frame-Options:Deny');

            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');
            $pdo = GetDb();

            $store_id           = $_GET['store_id'];
            $service_start_id   = $_GET['service_start_id'];
            $service_id         = $_GET['service_id'];


            $weekArr = array("日", "月", "火", "水", "木", "金", "土");

            //サービス
            $sql = "SELECT * FROM `m_service` 
        WHERE `store_id`= :store_id 
        AND`service_id`= :service_id
        ";
            $service_date = $pdo->prepare($sql);
            $service_date->bindParam(':service_id', $service_id);
            $service_date->bindParam(':store_id', $store_id);
            $service_date->execute();
            $get_service = $service_date->fetch(PDO::FETCH_ASSOC);

            $service_name   =   $get_service['service_name'];
            $service_title   =   $get_service['service_title'];



            echo ' 
            <div class="scroll">
            ';
            //ヘッダー
            echo "
            <table class='zebra'>
            <caption>$service_name  - $service_title</caption>
            <tbody>    
            <tr>          
            <th>回数</th>         
            <th style='width: 10%;'>日付</th>        
            <th style='width: 10%;'>時間</th>
            <th>部屋</th>
            <th>担任講師</th>
            <th  style='width: 3%;'>変更</th>
            <th  style='width: 3%;''>削除</th>
            </tr>       
            ";

            $sql = "SELECT * FROM `t_service_set_detail` 
                 WHERE `store_id`      = :store_id
                 AND`service_start_id` = :service_start_id
                 ";
            $service_detail_date = $pdo->prepare($sql);
            $service_detail_date->bindParam(':service_start_id', $service_start_id);
            $service_detail_date->bindParam(':store_id', $store_id);
            $service_detail_date->execute();


            while ($row = $service_detail_date->fetch(PDO::FETCH_ASSOC)) {

                $service_day_detail = $row['service_day_detail'];
                $service_nth        = $row['service_nth'];
                $service_nth_sub    = $row['service_nth_sub'];
                $start_time_detail  = $row['start_time_detail'];
                $end_time_detail    = $row['end_time_detail'];
                $room_id            = $row['room_id'];
                $teacher_detail     = $row['teacher_detail'];
                $note_detail        = $row['note'];
                //時間
                $start_num  = strtotime($start_time_detail);
                $end_num    = strtotime($end_time_detail);
                $start  = date("G:i", $start_num);
                $end    = date("G:i", $end_num);
                //部屋
                $sql = "SELECT * FROM `m_room` 
                WHERE `room_id`= :room_id 
                AND`store_id`= :store_id
                ";
                $room_date = $pdo->prepare($sql);
                $room_date->bindParam(':room_id', $room_id);
                $room_date->bindParam(':store_id', $store_id);
                $room_date->execute();
                $get_room = $room_date->fetch(PDO::FETCH_ASSOC);
                $room_name = $get_room['room_name'];
                //曜日
                $day_num = strtotime($service_day_detail);
                $week_num = date("w", $day_num);
                $youbi = $weekArr[$week_num];
                $service_day_detail = date("Y-n-j", $day_num);
                //講師
                if ($teacher_detail != null) {
                    $sql = "SELECT * FROM `m_systemuser` 
                WHERE`staff_id`= :teacher_detail
                ";
                    $teacher_date = $pdo->prepare($sql);
                    $teacher_date->bindParam(':teacher_detail', $teacher_detail);
                    $teacher_date->execute();
                    $get_teacher = $teacher_date->fetch(PDO::FETCH_ASSOC);
                    $teacher    = $get_teacher['last_name'] . $get_teacher['first_name'];
                } else {
                    $teacher = "";
                }

                //週間何回
                $sql = "SELECT `service_nth_sub`
                     FROM `t_service_set_detail` 
                     WHERE `store_id`= :store_id
                     AND`service_start_id`= :service_start_id
                     AND`service_nth`= :service_nth
                     ";
                $week_nth = $pdo->prepare($sql);
                $week_nth->bindParam(':store_id', $store_id);
                $week_nth->bindParam(':service_start_id', $service_start_id);
                $week_nth->bindParam(':service_nth', $service_nth);
                $week_nth->execute();

                $get_week_nth = $week_nth->rowCount();



                $sql = "SELECT MIN(service_nth_sub)
                     FROM `t_service_set_detail` 
                     WHERE `store_id`= :store_id
                     AND`service_start_id`= :service_start_id
                     AND`service_nth`= :service_nth
                     ";
                $get_min_nth = $pdo->prepare($sql);
                $get_min_nth->bindParam(':store_id', $store_id);
                $get_min_nth->bindParam(':service_start_id', $service_start_id);
                $get_min_nth->bindParam(':service_nth', $service_nth);
                $get_min_nth->execute();

                //結果の行を数値添字配列で取得する
                $get_min_nth_sub = $get_min_nth->fetch(PDO::FETCH_NUM);
                $min_nth_sub =  $get_min_nth_sub[0];


                //表中身
                echo "<tr>";
                if ($service_nth_sub == $min_nth_sub) {
                    echo "<td class='num' rowspan='$get_week_nth'>$service_nth</td>";
                }

                echo "<td>$service_day_detail ($youbi)</td>";
                echo "<td>$start~$end</td>";
                echo "<td>$room_name</td>";
                echo "<td>$teacher</td>";

                echo "<td>
                    <a href = 'service_detail_set.php?service_start_id=$service_start_id&store_id=$store_id&service_nth=$service_nth&service_nth_sub=$service_nth_sub'>
                        <button title='変更' class='button4'>更新</button>
                    </a>
                </td>
                ";
                echo "<td>
                    <a href = 'service_detail_delete.php?service_start_id=$service_start_id&store_id=$store_id&service_nth=$service_nth&service_nth_sub=$service_nth_sub'>
                        <button title='削除' class='button5' onclick='return confirm(\"削除しますか？\");'>削除</button>
                    </a>
            </td>";

                echo "</tr>";
            };

            echo "</tbody>
            </div>
            </table>
            <br>";
            $pdo = null;
    ?>


    </form>

    <form action="service_list.php" method="post">

        <?php
            echo '<input type="hidden"name="tid"value="' . $store_id . '">';
        ?>

        <input class="button" type="submit" value="戻る">
    </form>

<?php

        }
    }
?>
</body>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>