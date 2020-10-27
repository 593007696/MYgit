<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <title>サービス操作結果</title>
    <script type="text/javascript" src="js/security_lock .js"></script>

    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
    <h1><img src="img/logo3.png"></h1>
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

    <div class="center">

        <?php


            //クリックジャッキング防止
            header('X-Frame-Options:Deny');

            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');
            $pdo = GetDb();




            //サービスID
            $service_id             = $_POST['service_id'];
            //部屋ID
            $room_id                = $_POST['room_id'];
            //開始時間
            $start_time_base        = $_POST['start_time_base'];
            //終了時間
            $end_time_base          = $_POST['end_time_base'];
            //予約受付状態
            $service_reserve_flag   = $_POST['service_reserve_flag'];
            //備考
            $note                   = $_POST['note'];
            //店舗ID
            $store_id               = $_POST['store_id'];

            //担任講師
            $teacher_base           = $_POST['teacher_base'];

            //講座回数
            $frequency              = $_POST['frequency'];
            //週内何回
            $week_num               = $_POST['week_num'];
            //毎回の日付
            $nthday                 = $_POST['nthday'];
            //単位
            $unit                   = $_POST['unit'];
            //終了日
            //$end_day                = $_POST['end_day'];


            if (isset($_POST['service_start_id'])) {
                $button = "更新";

                $service_start_id = $_POST['service_start_id'];

                $sql = "DELETE FROM `t_service_set` 
            WHERE `t_service_set`.`store_id` = :store_id  
            AND `t_service_set`.`service_start_id` = :service_start_id
            ";
                $delete = $pdo->prepare($sql);
                $delete->bindParam(':store_id', $store_id);
                $delete->bindParam(':service_start_id', $service_start_id);
                $delete->execute(
                    array(
                        ':store_id' => $store_id,
                        ':service_start_id' => $service_start_id

                    )
                );

                if ($delete->rowCount() > 0) {
                } else {
                    echo  "更新失敗: " . "<br>" . $pdo->errorCode();
                    print_r($pdo->errorInfo());
                }



                $sql_2 =
                    "DELETE FROM `t_service_set_detail` 
                WHERE `store_id` = :store_id  
                AND `service_start_id` = :service_start_id
            ";
                $delete_2 = $pdo->prepare($sql_2);
                $delete_2->bindParam(':store_id', $store_id);
                $delete_2->bindParam(':service_start_id', $service_start_id);
                $delete_2->execute(
                    array(
                        ':store_id' => $store_id,
                        ':service_start_id' => $service_start_id

                    )
                );

                if ($delete_2->rowCount() > 0) {
                } else {
                    echo  "更新失敗: " . "<br>" . $pdo->errorCode();
                    print_r($pdo->errorInfo());
                };
            } else {
                $button = "登録";

                $sql =
                    "SELECT max(service_start_id) 
                FROM t_service_set 
                WHERE store_id = :store_id
                ";
                $maxid = $pdo->prepare($sql);
                $maxid->bindParam(':store_id', $store_id);
                $maxid->execute();

                $get_max_id = $maxid->fetch(PDO::FETCH_NUM);
                $service_start_id = $get_max_id[0] + 1;
            }




            echo "<h2>サービス $button 結果</h2>
            <div class='page'>
            <br>";
            for ($service_nth = 1; $service_nth <= $frequency; $service_nth++) {

                $y = $service_nth - 1;

                if ($unit == 7) {

                    for ($service_nth_sub = 1; $service_nth_sub <= $week_num; $service_nth_sub++) {

                        $i = $service_nth_sub - 1;

                        $service_day_detail = $nthday[$i][$y];

                        $sql_2 = "INSERT INTO
                    `t_service_set_detail` (
                    `store_id`,
                    `service_start_id`,
                    `service_nth`,
                    `service_nth_sub`,
                    `service_day_detail`,
                    `start_time_detail`,
                    `end_time_detail`,
                    `room_id`,
                    `teacher_detail`,
                    `note`
                        ) 
                    VALUES (
                    :store_id,
                    :service_start_id,
                    :service_nth,
                    :service_nth_sub,
                    :service_day_detail,
                    :start_time_base,
                    :end_time_base,
                    :room_id,
                    :teacher_base,
                    :note
                    )";
                        $into = $pdo->prepare($sql_2);
                        $into->bindParam(':store_id', $store_id);
                        $into->bindParam(':service_start_id', $service_start_id);
                        $into->bindParam(':service_nth', $service_nth);
                        $into->bindParam(':service_nth_sub', $service_nth_sub);
                        $into->bindParam(':service_day_detail', $service_day_detail);
                        $into->bindParam(':start_time_base', $start_time_base);
                        $into->bindParam(':end_time_base', $end_time_base);
                        $into->bindParam(':room_id', $room_id);
                        $into->bindParam(':teacher_base', $teacher_base);
                        $into->bindParam(':note', $note);
                        $into->execute(
                            array(
                                ':store_id' => $store_id,
                                ':service_start_id' => $service_start_id,
                                ':service_nth' => $service_nth,
                                ':service_nth_sub' => $service_nth_sub,
                                ':service_day_detail' => $service_day_detail,
                                ':start_time_base' => $start_time_base,
                                ':end_time_base' => $end_time_base,
                                ':room_id' => $room_id,
                                ':teacher_base' => $teacher_base,
                                ':note' => $note

                            )
                        );

                        if ($into->rowCount() > 0) {
                        } else {
                            echo "サービス詳細" . $button . "失敗: <br>" . $sql_2 . "<br>" . $pdo->errorCode();
                            print_r($pdo->errorInfo());
                        };
                    };

                    //開始日

                    $k = 0;
                    $start_day = $nthday[0][0];
                    while ($start_day == "0000-00-00") {
                        $k++;
                        $start_day = $nthday[$k][0];
                    };
                } else {

                    $service_nth_sub = 1;
                    $service_day_detail = $nthday[$y];

                    $sql_2 = "INSERT INTO
                `t_service_set_detail` (
                `store_id`,
                `service_start_id`,
                `service_nth`,
                `service_nth_sub`,
                `service_day_detail`,
                `start_time_detail`,
                `end_time_detail`,
                `room_id`,
                `teacher_detail`,
                `note`
                    ) 
                VALUES (
                :store_id,
                :service_start_id,
                :service_nth,
                :service_nth_sub,
                :service_day_detail,
                :start_time_base,
                :end_time_base,
                :room_id,
                :teacher_base,
                :note
                )";
                    $into = $pdo->prepare($sql_2);
                    $into->bindParam(':store_id', $store_id);
                    $into->bindParam(':service_start_id', $service_start_id);
                    $into->bindParam(':service_nth', $service_nth);
                    $into->bindParam(':service_nth_sub', $service_nth_sub);
                    $into->bindParam(':service_day_detail', $service_day_detail);
                    $into->bindParam(':start_time_base', $start_time_base);
                    $into->bindParam(':end_time_base', $end_time_base);
                    $into->bindParam(':room_id', $room_id);
                    $into->bindParam(':teacher_base', $teacher_base);
                    $into->bindParam(':note', $note);
                    $into->execute(
                        array(
                            ':store_id' => $store_id,
                            ':service_start_id' => $service_start_id,
                            ':service_nth' => $service_nth,
                            ':service_nth_sub' => $service_nth_sub,
                            ':service_day_detail' => $service_day_detail,
                            ':start_time_base' => $start_time_base,
                            ':end_time_base' => $end_time_base,
                            ':room_id' => $room_id,
                            ':teacher_base' => $teacher_base,
                            ':note' => $note

                        )
                    );

                    if ($into->rowCount() > 0) {
                    } else {
                        echo "サービス詳細" . $button . "失敗: <br>" . $sql_2 . "<br>" . $pdo->errorCode();
                        print_r($pdo->errorInfo());
                    };

                    //開始日
                    $start_day = $nthday[0];
                };
            };

            $end_day = $service_day_detail;


            $sql =
                "INSERT INTO 
            t_service_set (
            store_id,
            service_start_id,
            start_day,
            end_day,
            service_id,
            room_id,
            service_reserve_flag,
            start_time_base,
            end_time_base,
            teacher_base,
            note
            ) 
            VALUES (
            :store_id,
            :service_start_id,
            :start_day,
            :end_day,
            :service_id,
            :room_id,
            :service_reserve_flag,
            :start_time_base,
            :end_time_base,
            :teacher_base,
            :note
            )";

            $into = $pdo->prepare($sql);
            $into->bindParam(':store_id', $store_id);
            $into->bindParam(':service_start_id', $service_start_id);
            $into->bindParam(':start_day', $start_day);
            $into->bindParam(':end_day', $end_day);
            $into->bindParam(':service_id', $service_id);
            $into->bindParam(':service_reserve_flag', $service_reserve_flag);
            $into->bindParam(':start_time_base', $start_time_base);
            $into->bindParam(':end_time_base', $end_time_base);
            $into->bindParam(':room_id', $room_id);
            $into->bindParam(':teacher_base', $teacher_base);
            $into->bindParam(':note', $note);
            $into->execute(
                array(
                    ':store_id' => $store_id,
                    ':service_start_id' => $service_start_id,
                    ':start_day' => $start_day,
                    ':end_day' => $end_day,
                    ':service_id' => $service_id,
                    ':service_reserve_flag' => $service_reserve_flag,
                    ':start_time_base' => $start_time_base,
                    ':end_time_base' => $end_time_base,
                    ':room_id' => $room_id,
                    ':teacher_base' => $teacher_base,
                    ':note' => $note

                )
            );


            if ($into->rowCount() > 0) {
                echo "サービス" . $button . "成功<br><br>";
            } else {
                echo "サービス" . $button . "失敗: " . $sql . "<br>" . $pdo->errorCode();
                print_r($pdo->errorInfo());
            };





            $sql_3 =
                "DELETE FROM `t_service_set_detail` 
            WHERE `store_id` = :store_id
            AND `service_start_id` = :service_start_id
            AND `service_day_detail`='0000-00-00'
            ";

            $delete_3 = $pdo->prepare($sql_3);
            $delete_3->bindParam(':store_id', $store_id);
            $delete_3->bindParam(':service_start_id', $service_start_id);
            $delete_3->execute(
                array(
                    ':store_id' => $store_id,
                    ':service_start_id' => $service_start_id
                )
            );


            $pdo = null;

        ?>

        <form action="service_list.php" method="post">

            <?php
            echo '<input type="hidden"name="tid"value="' . $store_id . '">';
            ?>

    </div>
    <input class="button3" type="submit" value="サービス一覧へ">
    </div>
    </form>
<?php

        }
    }
?>
</body>

<label class="foot"> ©2020 株式会社ジェイテック</label>

</html>