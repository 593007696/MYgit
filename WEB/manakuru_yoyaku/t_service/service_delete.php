<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>サービス削除確認</title>
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

        <h2>サービス削除確認</h2>
        <h4>
            <font color=red>こちらのサービス削除しますか</font>
        </h4>
        <div class="page">
            <form action="service_delete_result.php" method="post">

                <?php
                //クリックジャッキング防止
                header('X-Frame-Options:Deny');

                //データベース接続
                include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');
                $pdo = GetDb();

                $service_start_id = "";
                $service_start_id = $_GET['service_start_id'];
                $store_id   = "";
                $store_id   = $_GET['store_id'];

                $sql = "SELECT * FROM `t_service_set` 
                        WHERE `t_service_set`.`store_id` = :store_id  
                        AND `t_service_set`.`service_start_id` = :service_start_id";

                $service_set_date = $pdo->prepare($sql);
                $service_set_date->bindParam(':service_start_id', $service_start_id);
                $service_set_date->bindParam(':store_id', $store_id);
                $service_set_date->execute();
                $row = $service_set_date->fetch(PDO::FETCH_ASSOC);



                $service_id             =   $row['service_id'];
                $start_day              =   $row['start_day'];
                $end_day                =   $row['end_day'];
                $start_time_base        =   $row['start_time_base'];
                $end_time_base          =   $row['end_time_base'];
                $teacher_base           =   $row['teacher_base'];
                $service_reserve_flag   =   $row['service_reserve_flag'];
                $note                   =   $row['note'];

                if ($service_reserve_flag == 1) {
                    $service_reserve_flag = "開始";
                } elseif ($service_reserve_flag == 0) {
                    $service_reserve_flag = "<font color=red>未開始</font>";
                } else {
                    $service_reserve_flag = " ";
                }

                $sql = "SELECT * FROM `m_service` 
                        WHERE `service_id`= :service_id 
                        AND`store_id`= :store_id
                        ";
                $service_date = $pdo->prepare($sql);
                $service_date->bindParam(':service_id', $service_id);
                $service_date->bindParam(':store_id', $store_id);
                $service_date->execute();
                $get_service = $service_date->fetch(PDO::FETCH_ASSOC);

                $service_name   =   $get_service['service_name'];
                $service_title  =   $get_service['service_title'];


                if ($teacher_base != null) {
                    $sql = "SELECT * FROM `m_systemuser` 
                            WHERE`staff_id`= :teacher_base
                            ";
                    $teacher_date = $pdo->prepare($sql);
                    $teacher_date->bindParam(':teacher_base', $teacher_base);
                    $teacher_date->execute();
                    $get_teacher = $teacher_date->fetch(PDO::FETCH_ASSOC);

                    $teacher_base_l   =   $get_teacher['last_name'] . $get_teacher['first_name'];
                } else {
                    $teacher_base_l   = "";
                }


                $start_time_base_number = strtotime($start_time_base);
                $start_time_base = date("G:i", $start_time_base_number);

                $end_time_base_number = strtotime($end_time_base);
                $end_time_base = date("G:i", $end_time_base_number);




                echo    '<input type="hidden"name="service_start_id"value="' . $service_start_id . '">';
                echo    '<input type="hidden"name="store_id"value="' . $store_id . '">';

                echo    "<br><a>サービス名:</a><a>
                        $service_name -$service_title
                        </a><hr>";

                echo    "サービス開始日:" . $start_day . "<hr>";
                echo    "サービス終了日:" . $end_day . "<hr>";
                echo    "開始時間:" . $start_time_base . "<hr>";
                echo    "終了時間 :" . $end_time_base . "<hr>";
                echo    "担任講師 :" . $teacher_base_l . "<hr>";
                echo    "予約受付状態:" . $service_reserve_flag . "<hr>";
                echo    "備考欄:" . $note;

                $pdo = null;
                ?>

        </div>


        <input class="button" type="submit" value="削除" style="float:left;margin-left:40%" onclick='return confirm("削除しますか？");'>
        </form>



        <form action="service_list.php" method="post">

            <?php
            echo '<input type="hidden"name="tid"value="' . $store_id . '">';
            ?>

            <input class="button" type="submit" value="戻る" style="float:left;margin-left:1%">
        </form>
    </div>
<?php

        }
    }
?>
</body>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>