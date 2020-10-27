<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <title>サービス詳細変更</title>
    <script type="text/javascript" src="js/security_lock .js"></script>

    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/checkbox.css" type="text/css">
    <link rel="stylesheet" href="css/form.css" type="text/css">

    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
    <script type="text/javascript">
        //時間入力欄クリア
        function s_del() {

            document.getElementById("start_time_detail").value = null;

        }

        function e_del() {

            document.getElementById("end_time_detail").value = null;

        }
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
            echo "一定時間で操作をしませんでした。ログインし直してください。<br><a href='http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/login.php'>ログインへ</a>";
        } else {

            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/SessionManager.php');


    ?>
</div>

<h1><img src="img/logo3.png"></h1>

<body>


    <h2 class="center">サービス詳細変更</h2>


    <form action="service_detail_set_result.php" method="post">
        <?php

            //クリックジャッキング防止
            header('X-Frame-Options:Deny');

            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');
            $pdo = GetDb();

            $store_id           = $_GET['store_id'];
            $service_start_id   = $_GET['service_start_id'];
            $service_nth        = $_GET['service_nth'];
            $service_nth_sub    = $_GET['service_nth_sub'];
            echo '<input type="hidden"name="store_id"value="' . $store_id . '">';
            echo '<input type="hidden"name="service_start_id"value="' . $service_start_id . '">';

            $sql = "SELECT * FROM `t_service_set_detail` 
                 WHERE `store_id`       = :store_id
                 AND`service_start_id`  = :service_start_id
                 AND`service_nth`       = :service_nth
                 AND`service_nth_sub`   = :service_nth_sub
                 ";
            $service_detail_date = $pdo->prepare($sql);
            $service_detail_date->bindParam(':service_start_id', $service_start_id);
            $service_detail_date->bindParam(':store_id', $store_id);
            $service_detail_date->bindParam(':service_nth', $service_nth);
            $service_detail_date->bindParam(':service_nth_sub', $service_nth_sub);
            $service_detail_date->execute();
            $row = $service_detail_date->fetch(PDO::FETCH_ASSOC);


            $service_day_detail = $row['service_day_detail'];
            $service_nth        = $row['service_nth'];
            $service_nth_sub    = $row['service_nth_sub'];
            $start_time_detail  = $row['start_time_detail'];
            $end_time_detail    = $row['end_time_detail'];
            $room_id_t          = $row['room_id'];
            $teacher_detail     = $row['teacher_detail'];
            $note               = $row['note'];

            echo "<div class='center'>
            <font size= '5'>" . $service_nth . "-" . $service_nth_sub . "回目</font>
            </div>";

            echo '<input type="hidden"name="service_nth"value="' . $service_nth . '">';
            echo '<input type="hidden"name="service_nth_sub"value="' . $service_nth_sub . '">';

            $sql = "SELECT * FROM `m_room` 
            WHERE`store_id`= :store_id
            ";
            $room_date = $pdo->prepare($sql);
            $room_date->bindParam(':store_id', $store_id);
            $room_date->execute();


            echo "
            <div class='form'>
            <ul>
            <li>
            <label>部屋:</label>";
            echo "
                    <select required name='room_id' class='input'>
                    <option value='' selected>部屋をお選びください</option>
                    ";
            while ($get_room = $room_date->fetch(PDO::FETCH_ASSOC)) {

                $room_name   =   $get_room['room_name'];

                $room_id     =   $get_room['room_id'];

                if ($room_id == $room_id_t) {
                    $room_select = 'selected';
                } else {
                    $room_select = '';
                }

                echo "
                    <option $room_select value=$room_id>$room_name</option>
                    ";
            }
            echo "</select>
            </li>";

            echo "<li>
            <label>日付:</label>";
            echo "
                    <input 
                    required
                    class='input'
                    type='date'
                    name='service_day_detail'
                    value='$service_day_detail'
                    >
                    </li>";

            echo "<li>
            <label>開始時間:</label>";
            echo "

                    <input 
                    required
                    class='input'
                    type='text' 
                    list='time_list' 
                    placeholder='--:--' 
                    autocomplete='off' 
                    onfocus='s_del()' 
                    onclick='s_del()' 
                    style='width:60px;'
                    name='start_time_detail'
                    id='start_time_detail'
                    value='" . $start_time_detail . "'
                    >
                    <datalist id='time_list'>
                    ";
            for ($h = 0; $h < 24; $h++) {

                $m = array('00', '15', '30', '45');

                for ($position = 0; $position < 4; $position++) {
                    echo '<option value="' . $h . ':' . $m[$position] . '"></option>';
                }
            }

            echo "</datalist>";

            echo "<a>~</a>";

            echo "
                    
                    <input 
                    required
                    class='input'
                    type='text' 
                    list='time_list' 
                    placeholder='--:--' 
                    autocomplete='off' 
                    onfocus='e_del()' 
                    onclick='e_del()' 
                    style='width:60px;'
                    name='end_time_detail'
                    id='end_time_detail'
                    value='" . $end_time_detail . "'
                    >
                    <datalist id='time_list'>
                ";

            for ($h = 0; $h < 24; $h++) {

                $m = array('00', '15', '30', '45');

                for ($position = 0; $position < 4; $position++) {
                    echo '<option value="' . $h . ':' . $m[$position] . '"></option>';
                }
            }

            echo "
                    </datalist>
                    </li>
                    ";

            $teacher = "1";
            $sql = "SELECT * FROM `m_systemuser` 
            WHERE`teacher`= :teacher";
            $teacher_date = $pdo->prepare($sql);
            $teacher_date->bindParam(':teacher', $teacher);
            $teacher_date->execute();

            echo "<li>
            <label>担任講師:</label>
            
                <select  name='teacher_detail' class='input'>
                <option value='' selected>講師をお選びください</option>
                ";
            while ($get_teacher = $teacher_date->fetch(PDO::FETCH_ASSOC)) {

                $last_name   =   $get_teacher['last_name'];

                $first_name  =   $get_teacher['first_name'];

                $staff_id    =   $get_teacher['staff_id'];

                if ($staff_id == $teacher_detail) {
                    $teacher_select = 'selected';
                } else {
                    $teacher_select = '';
                }

                echo "
                    <option $teacher_select value=$staff_id >$last_name $first_name</option>
                    ";
            }
            echo "</select>
            </li>";

            echo "
            <li>
            <label>備考:</label>
            <textarea class='input' rows='1' name='note'>$note</textarea>
            </li>
           ";
        ?>

        </ul>
        </div>
        <div class="center">
            <input class='button' type='submit' value='更新' onclick="return confirm('更新しますか？');">

            <input class="button" type="button" value="戻る" onclick="history.back()">
        </div>
    </form>



<?php

        }
    }
?>
</body>
<br><br>
<label class="foot"> ©2020 株式会社ジェイテック</label>

</html>