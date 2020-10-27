<!DOCTYPE html>

<head>
    <meta charset="utf-8">

    <title>受付・予約画面</title>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/checkbox.css" type="text/css">



    <script type="text/javascript">
        $(document).ready(function() {

            $("p").hide();

            $("#time_line").mouseover(function() {
                $("p").show();
            });

            $("#time_line").mouseout(function() {

                $("p").hide();

            });
        });
    </script>


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
            echo "一定時間で操作をしませんでした。ログインし直してください。<a href='http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/login.php'>ログインへ</a>";
        } else {

            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/SessionManager.php');


    ?>
</div>
<h1><img src="img/logo3.png"></h1>

<?php
            //POSTセキュリティー
            include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");
            //データベース接続
            include('C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\DbManager.php');

            //timezon設定
            date_default_timezone_set('Asia/Tokyo');

?>


<html>

<body>
    <div class="center">
        <h2>予約受付</h2>

        <div>
            <?php


            $pdo = GetDb();

            $today = date("Y-m-d");
            $store_id = $_SESSION["STORE_ID"];

            //当日コース
            $sql  = "SELECT * 
            FROM `t_service_set_detail` 
            JOIN `m_systemuser` ON (`t_service_set_detail`.`teacher_detail` = `m_systemuser`.`staff_id`) 
            JOIN `t_service_set` USING(`service_start_id`,`store_id`) 
            JOIN `m_service` USING(`service_id`,`store_id`) 
            WHERE `m_service`.`service_flg` = '0' 
            AND `t_service_set_detail` .`store_id` = '$store_id' 
            AND `t_service_set_detail` .`service_day_detail` = '$today' 
            ORDER BY `t_service_set_detail`.`start_time_detail` ASC";
            $today_course = $pdo->prepare($sql);
            $today_course->execute();

            $today_course_count =  $today_course->rowCount();



            //当日コワーキング
            $sql  = "SELECT * 
            FROM `t_service_set_detail` 
            JOIN `t_service_set` USING(`service_start_id`,`store_id`) 
            JOIN `m_service` USING(`service_id`,`store_id`) 
            WHERE `m_service`.`service_flg` = '1' 
            AND `t_service_set_detail` .`store_id` = '$store_id' 
            AND `t_service_set_detail` .`service_day_detail` = '$today' 
            ORDER BY `t_service_set_detail`.`start_time_detail` ASC";
            $today_coworking = $pdo->prepare($sql);
            $today_coworking->execute();

            $today_coworking_count = $today_coworking->rowCount();



            //部屋データ
            $sql  = "SELECT * 
                FROM `m_room` 
                WHERE `store_id` = '$store_id'
                ";
            $room = $pdo->prepare($sql);
            $room->execute();

            $room_count = $room->rowCount();


            ?>
        </div>



        <!--main page-->
        <br>
        <br>
        <form method="POST" action="">
            <a>日付:</a>
            <input type=date name="start_date" id="today1"> ~ <input type=date name="end_date" id="today2">
            <input type="submit" value="検索">
        </form>

        <br>
        <br>


    </div>
    <div class="scroll">
        <table class="zebra">

            <thead>

                <tr>
                    <th></th>
                    <?php
                    for ($h = 0; $h < 24; $h++) {

                        echo "<th colspan ='4'>$h 時</th>";
                    }

                    ?>


                </tr>
            </thead>

            <tbody>



                <?php

                if ($room_count > 0) :
                    while ($room_date = $room->fetch(PDO::FETCH_ASSOC)) {
                        $room_name  = $room_date["room_name"];
                        $room_id    = $room_date["room_id"];

                        echo "<tr>
                    <th>
                    $room_name
                   
                    </th>";


                        $sql = "SELECT 
                    `m_service`.`service_name`,
                    `m_service`.`service_title`,
                    `m_systemuser`.`last_name`,
                    `m_systemuser`.`first_name`,
                    `t_service_set_detail`.`start_time_detail`,
                    `t_service_set_detail`.`end_time_detail`,
                    `t_service_set_detail`.`note`                    
                    FROM `t_service_set_detail` 
                    JOIN `m_systemuser` ON (`t_service_set_detail`.`teacher_detail` = `m_systemuser`.`staff_id`) 
                    JOIN `t_service_set` USING(`service_start_id`,`store_id`) 
                    JOIN `m_service` USING(`service_id`,`store_id`) 
                    WHERE `m_service`.`service_flg` = '0' 
                    AND `t_service_set_detail` .`store_id` = '$store_id' 
                    AND `t_service_set_detail` .`service_day_detail` = '$today' 
                    AND `t_service_set_detail` .`room_id` = '$room_id' 
                    ORDER BY `t_service_set_detail`.`start_time_detail` ASC";

                        $course_table = $pdo->prepare($sql);
                        $course_table->execute();

                        $course_table_count = $course_table->rowCount();


                        if ($course_table_count > 0) {
                            $in_the_room = 1;

                            while ($course_date = $course_table->fetch(PDO::FETCH_ASSOC)) {

                                $service_name = $course_date["service_name"];
                                $service_title = $course_date["service_title"];
                                $teacher = $course_date["last_name"] . $course_date["first_name"];
                                $note = $course_date["note"];

                                if ($in_the_room > 1) {
                                    $m = ($end_h * 4);
                                } else {
                                    $m = 0;
                                }

                                $start_time_detail  = $course_date["start_time_detail"];
                                $start_h  = date("H", strtotime($start_time_detail));
                                $start_m  = date("i", strtotime($start_time_detail));
                                $start  = ($start_h * 4) + ($start_m / 15);

                                $end_time_detail    = $course_date["end_time_detail"];
                                $end_h  = date("H", strtotime($end_time_detail));
                                $end_m  = date("i", strtotime($end_time_detail));
                                $end  = ($end_h * 4) + ($end_m / 15);

                                $i = 15;




                                for ($m; $m < ($end_h * 4); $m++) {
                                    $y = ($m + 1);
                                    if ($i > 60) {
                                        $i = 15;
                                    }
                                    if (
                                        ($start <= $m) && (($end - 1) >= $m)
                                    ) {

                                        echo "<td id='time_line' bgcolor='#C0BEDB'>
                                    <a>$service_name</a>
                                        <button onclick='detail()'>詳細</button>
                                        <script>
                                             var str = '" . $service_title . $teacher . $note . "';
                                             function detail() {
                                                
                                                 alert(str)
                                             }
                                         </script>

                        
                                            
                                            </td>";
                                    } else {
                                        echo "<td>$y<br>$i</td>";
                                    }

                                    $i = $i + 15;
                                }
                                $in_the_room++;

                                if ($in_the_room > $course_table_count) {
                                    for ($m; $m < 96; $m++) {
                                        $y = ($m + 1);
                                        if ($i > 60) {
                                            $i = 15;
                                        }
                                        echo "<td>$y<br>$i</td>";
                                        $i = $i + 15;
                                    }
                                }
                            }
                        } else {

                            $i = 15;
                            for ($m = 0; $m < 96; $m++) {

                                if ($i > 60) {
                                    $i = 15;
                                }

                                $y = ($m + 1);

                                echo "<td>$y<br>$i</td>";

                                $i = $i + 15;
                            }
                        }



                        echo "</tr>";
                    }

                ?>


            </tbody>


        <?php endif ?>




        <tfoot>

        </tfoot>
        </table>
    </div>

    <div class="center">
        <br>
        <br>
        <a href="../main.php">
            <input type="button" class="button" value="戻る"></input>
        </a>


</body>
</div>
<?php

        }
    }
?>
<br>
<br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>