<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <title>サービス詳細設定更新</title>
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
<div>
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
<?php
            //POSTセキュリティー
            include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");
?>

<body>


    <?php

            //クリックジャッキング防止
            header('X-Frame-Options:Deny');

            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');
            $pdo = GetDb();



            echo "<div class='center'>";

            echo "<h2>サービス詳細変更</h2>";

            echo "<div class='page'>
            <br>";

            $store_id           = $_POST['store_id'];
            $service_start_id   = $_POST['service_start_id'];
            $service_day_detail = $_POST['service_day_detail'];
            $service_nth        = $_POST['service_nth'];
            $service_nth_sub    = $_POST['service_nth_sub'];
            $start_time_detail  = $_POST['start_time_detail'];
            $end_time_detail    = $_POST['end_time_detail'];
            $room_id            = $_POST['room_id'];
            $teacher_detail     = $_POST['teacher_detail'];
            $note               = $_POST['note'];

            /********************************************************************
            $note    = trim($_POST['note']);  //スペース削除 

            $note    = strip_tags($note);   //htmlタグ削除

            $note    = htmlspecialchars($note);   //正規化  

            $note    = addslashes($note);  //SQL注入対策
             ********************************************************************/



            //ｎ回の開始日はｎ+α回の開始日より前かのエラーチェック
            $next_time_over = "SELECT * FROM t_service_set_detail
            WHERE `store_id` = :store_id
            AND `service_start_id` = :service_start_id
            AND `service_nth` > :service_nth
            AND `service_day_detail` < :service_day_detail
            ";
            $check_next_time_over = $pdo->prepare($next_time_over);
            $check_next_time_over->bindParam(':service_start_id', $service_start_id);
            $check_next_time_over->bindParam(':store_id', $store_id);
            $check_next_time_over->bindParam(':service_nth', $service_nth);
            $check_next_time_over->bindParam(':service_day_detail', $service_day_detail);
            $check_next_time_over->execute();

            $next_time_over_number = $check_next_time_over->rowCount();


            //ｎ回の開始日はｎ+α回の開始日同じの場合開始時間のエラーチェック
            $same_next_time_over = "SELECT * FROM t_service_set_detail
            WHERE `store_id` = :store_id
            AND `service_start_id` = :service_start_id
            AND `service_nth` > :service_nth
            AND `service_day_detail` = :service_day_detail
            AND`start_time_detail`< :end_time_detail
            ";
            $check_same_next_time_over = $pdo->prepare($same_next_time_over);
            $check_same_next_time_over->bindParam(':service_start_id', $service_start_id);
            $check_same_next_time_over->bindParam(':store_id', $store_id);
            $check_same_next_time_over->bindParam(':service_nth', $service_nth);
            $check_same_next_time_over->bindParam(':service_day_detail', $service_day_detail);
            $check_same_next_time_over->bindParam(':end_time_detail', $end_time_detail);
            $check_same_next_time_over->execute();

            $same_next_time_over_number = $check_same_next_time_over->rowCount();


            //ｎ回の開始日はｎ-α回の開始日より後かのエラーチェック
            $last_time_over = "SELECT * FROM t_service_set_detail
            WHERE `store_id` = :store_id
            AND `service_start_id` = :service_start_id
            AND `service_nth` < :service_nth
            AND `service_day_detail` > :service_day_detail
            ";
            $check_last_time_over = $pdo->prepare($last_time_over);
            $check_last_time_over->bindParam(':service_start_id', $service_start_id);
            $check_last_time_over->bindParam(':store_id', $store_id);
            $check_last_time_over->bindParam(':service_nth', $service_nth);
            $check_last_time_over->bindParam(':service_day_detail', $service_day_detail);
            $check_last_time_over->execute();

            $last_time_over_number = $check_last_time_over->rowCount();



            //ｎ回の開始日はｎ-α回の開始日同じの場合開始時間のエラーチェック
            $same_last_time_over = "SELECT * FROM t_service_set_detail
            WHERE `store_id` = :store_id
            AND `service_start_id` = :service_start_id
            AND `service_nth` < :service_nth
            AND `service_day_detail` = :service_day_detail
            AND`end_time_detail`>= :start_time_detail
            ";
            $check_same_last_time_over = $pdo->prepare($same_last_time_over);
            $check_same_last_time_over->bindParam(':service_start_id', $service_start_id);
            $check_same_last_time_over->bindParam(':store_id', $store_id);
            $check_same_last_time_over->bindParam(':service_nth', $service_nth);
            $check_same_last_time_over->bindParam(':service_day_detail', $service_day_detail);
            $check_same_last_time_over->bindParam(':start_time_detail', $start_time_detail);
            $check_same_last_time_over->execute();

            $same_last_time_over_number = $check_same_last_time_over->rowCount();



            $over_number = $last_time_over_number
                + $next_time_over_number
                + $same_next_time_over_number
                + $same_last_time_over_number;

            if ($over_number > 0) {
                echo "<font color=red>設定された日付又は時間は設定することはできません、
                        <br>
                        日付又は時間直してください。</font><br>";
                echo "<input type='button' value='戻る' onclick='history.back()'>";
                $cont_error = 1;
            } else {


                //時間帯重なるチェック

                $sql_same = "SELECT * from t_service_set_detail 
                WHERE service_start_id <> :service_start_id
                AND room_id = :room_id
                AND service_day_detail = :service_day_detail
                AND store_id = :store_id
                AND	start_time_detail <= :end_time_detail
                AND	end_time_detail >= :start_time_detail
                ";
                $check_same = $pdo->prepare($sql_same);
                $check_same->bindParam(':service_start_id', $service_start_id);
                $check_same->bindParam(':room_id', $room_id);
                $check_same->bindParam(':store_id', $store_id);
                $check_same->bindParam(':service_day_detail', $service_day_detail);
                $check_same->bindParam(':end_time_detail', $end_time_detail);
                $check_same->bindParam(':start_time_detail', $start_time_detail);
                $check_same->execute();

                $same_number = $check_same->rowCount();



                if ($same_number > 0) {

                    //重なるデータ獲得
                    $get_same       = $check_same->fetch(PDO::FETCH_ASSOC);

                    $same_start     = $get_same['start_time_detail'];
                    $same_end       = $get_same['end_time_detail'];
                    $same_start_id  = $get_same['service_start_id'];
                    $same_nth       = $get_same['service_nth'];
                    $same_nth_sub   = $get_same['service_nth'];
                    //重複サービスID
                    $same_service =
                        "SELECT * FROM `t_service_set` 
                    WHERE `store_id`= :store_id
                    AND`service_start_id`= :same_start_id
                    ";
                    $same_service_date = $pdo->prepare($same_service);
                    $same_service_date->bindParam(':store_id', $store_id);
                    $same_service_date->bindParam(':same_start_id', $same_start_id);
                    $same_service_date->execute();
                    $get_same_service = $same_service_date->fetch(PDO::FETCH_ASSOC);

                    $same_service_id    = $get_same_service['service_id'];

                    //重複サービス
                    $same_service_name =
                        "SELECT * FROM `m_service` 
                    WHERE `store_id`	= :store_id 
                    AND`service_id`		= :same_service_id
                    ";
                    $same_service_name_date = $pdo->prepare($same_service_name);
                    $same_service_name_date->bindParam(':store_id', $store_id);
                    $same_service_name_date->bindParam(':same_service_id', $same_service_id);
                    $same_service_name_date->execute();

                    $get_same_name = $same_service_name_date->fetch(PDO::FETCH_ASSOC);

                    $same_service_flg   = $get_same_name['service_flg'];



                    if ($same_service_flg == 0) {
                        $same_name    = $get_same_name['service_name'];
                        $same_title    = $get_same_name['service_title'];
                        //重複部屋
                        $same_room =
                            "SELECT * FROM `m_room` 
                        WHERE `store_id`= :store_id
                        AND`room_id`= :room_id
                        ";
                        $same_room_date = $pdo->prepare($same_room);
                        $same_room_date->bindParam(':store_id', $store_id);
                        $same_room_date->bindParam(':room_id', $room_id);
                        $same_room_date->execute();
                        $get_same_room = $same_room_date->fetch(PDO::FETCH_ASSOC);

                        $room_name      = $get_same_room['room_name'];

                        //エラー表示
                        echo "<h1><font color=red>エラー</font></h1>";

                        echo "<font color=red>
                                $same_name<br>
                                $same_title<br>
                                第 $same_nth - $same_nth_sub 回目 <br>
                                $service_day_detail <br> 
                                $same_start~$same_end<br>
                                部屋:$room_name<br> 
                                使用中の為。
                                </font><br><br>";


                        echo    "<font>
                            $service_day_detail <br> 
                            $start_time_detail~$end_time_detail<br>
                            部屋:$room_name<br>
                            使用不可です,
                            部屋又は時間変更してください。
                            </font><br><br>
                            ";

                        echo    "<input type='button' value='戻る' onclick='history.back()'>";

                        $cont_error = 1;
                    } else {
                        $cont_error = 0;
                    }
                } else {
                    $cont_error = 0;
                }
            };


            if ($cont_error == 0) {
                $sql = "DELETE FROM `t_service_set_detail` 
                WHERE `store_id` = :store_id 
                AND `service_start_id` = :service_start_id
                AND `service_nth` = :service_nth
                AND `service_nth_sub` = :service_nth_sub
                ";
                $delete = $pdo->prepare($sql);
                $delete->bindParam(':service_start_id', $service_start_id);
                $delete->bindParam(':store_id', $store_id);
                $delete->bindParam(':service_nth', $service_nth);
                $delete->bindParam(':service_nth_sub', $service_nth_sub);
                $delete->execute(
                    array(
                        ':service_start_id' => $service_start_id,
                        ':store_id' => $store_id,
                        ':service_nth' => $service_nth,
                        ':service_nth_sub' => $service_nth_sub
                    )
                );



                if ($delete->rowCount() > 0) {
                } else {
                    echo  "更新失敗: " . $sql . "<br>" . $pdo->errorCode();
                    print_r($pdo->errorInfo());
                }




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
                        :start_time_detail,
                        :end_time_detail,
                        :room_id,
                        :teacher_detail,
                        :note
                        )";

                $into = $pdo->prepare($sql_2);
                $into->bindParam(':service_start_id', $service_start_id);
                $into->bindParam(':store_id', $store_id);
                $into->bindParam(':service_nth', $service_nth);
                $into->bindParam(':service_nth_sub', $service_nth_sub);
                $into->bindParam(':service_day_detail', $service_day_detail);
                $into->bindParam(':start_time_detail', $start_time_detail);
                $into->bindParam(':end_time_detail', $end_time_detail);
                $into->bindParam(':room_id', $room_id);
                $into->bindParam(':teacher_detail', $teacher_detail);
                $into->bindParam(':note', $note);
                $into->execute(
                    array(
                        ':service_start_id' => $service_start_id,
                        ':store_id' => $store_id,
                        ':service_nth' => $service_nth,
                        ':service_nth_sub' => $service_nth_sub,
                        ':service_day_detail' => $service_day_detail,
                        ':start_time_detail' => $start_time_detail,
                        ':end_time_detail' => $end_time_detail,
                        ':room_id' => $room_id,
                        ':teacher_detail' => $teacher_detail,
                        ':note' => $note

                    )
                );

                if ($into->rowCount() > 0) {
                    echo "サービス詳細更新成功<br>";
                } else {
                    echo  "更新失敗: " . $sql_2 . "<br>" . $pdo->errorCode();
                    print_r($pdo->errorInfo());
                }



                //詳細の最初変わると大元にも変更
                if ($service_nth == 1) {

                    $sql =
                        "UPDATE  `t_service_set` 
                        SET`start_day`= :service_day_detail
                        WHERE `store_id`= :store_id
                        AND `service_start_id` = :service_start_id
                        ";
                    $update = $pdo->prepare($sql);
                    $update->bindParam(':service_day_detail', $service_day_detail);
                    $update->bindParam(':store_id', $store_id);
                    $update->bindParam(':service_start_id', $service_start_id);
                    $update->execute(
                        array(
                            ':service_day_detail' => $service_day_detail,
                            ':store_id' => $store_id,
                            ':service_start_id' => $service_start_id
                        )
                    );
                };

                //詳細の最終変わると大元にも変更
                $sql =
                    "SELECT max(service_nth) 
                FROM `t_service_set_detail` 
                WHERE `store_id`= :store_id
                AND `service_start_id`= :service_start_id
            ";
                $max_nth = $pdo->prepare($sql);
                $max_nth->bindParam(':service_start_id', $service_start_id);
                $max_nth->bindParam(':store_id', $store_id);
                $max_nth->execute();

                $get_max_nth = $max_nth->fetch(PDO::FETCH_NUM);
                $max_service_nth =  $get_max_nth[0];


                if ($service_nth == $max_service_nth) {
                    $sql =
                        "UPDATE  `t_service_set` 
                    SET`end_day`= :service_day_detail
                    WHERE `store_id`= :store_id
                    AND `service_start_id` = :service_start_id
                    ";
                    $update = $pdo->prepare($sql);
                    $update->bindParam(':service_day_detail', $service_day_detail);
                    $update->bindParam(':store_id', $store_id);
                    $update->bindParam(':service_start_id', $service_start_id);
                    $update->execute(
                        array(
                            ':service_day_detail' => $service_day_detail,
                            ':store_id' => $store_id,
                            ':service_start_id' => $service_start_id
                        )
                    );
                };


                $pdo = null;

                echo "
                <br>
                </div>";

                echo "<form action='service_list.php' method='post'>";

                echo '<input type="hidden"name="tid"value="' . $store_id . '">';

                echo '<input class="button3" type="submit" value="サービス一覧へ">';

                echo "</form>";
            };

    ?>
    </div>
<?php

        }
    }
?>
</body>

<label class="foot"> ©2020 株式会社ジェイテック</label>

</html>