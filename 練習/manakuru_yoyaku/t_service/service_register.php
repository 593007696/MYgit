<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <title>サービス登録/更新</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/security_lock .js"></script>

    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/form.css" type="text/css">
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />

    <script type="text/javascript">
        $(document).ready(function() {

            if ($('#unit').val() == 1) {
                $('input[type=checkbox]').attr('disabled', true);
                $('input[type=checkbox]:checked').prop('checked', false);
            } else {
                $('input[type=checkbox]').attr('disabled', false);
            }

            if ($('#unit').val() == "") {
                $('input[type=checkbox]').attr('disabled', true);
                $('input[type=checkbox]:checked').prop('checked', false);
            }

            $('select[name=unit]').change(function() {
                if ($('#unit').val() == 1) {
                    $('input[type=checkbox]').attr('disabled', true);
                    $('input[type=checkbox]:checked').prop('checked', false);
                } else {
                    $('input[type=checkbox]').attr('disabled', false);
                }

                if ($('#unit').val() == "") {
                    $('input[type=checkbox]').attr('disabled', true);
                    $('input[type=checkbox]:checked').prop('checked', false);
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('input[name=submit]').click(function() {

                if ($("input[type='checkbox']:disabled").length == 0) {
                    if ($("input[type='checkbox']:checked").length < 1) {
                        alert("曜日は少なくとも一つを選んでください");
                        return false;
                    }



                }
            });
        });
    </script>

    <script type="text/javascript">
        //時間入力欄クリア
        function s_del() {

            document.getElementById("start_time_base").value = null;

        }

        function e_del() {

            document.getElementById("end_time_base").value = null;

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


<h1><img src="img/logo3.png"></h1>

<body>



    <form action="service_register_confirm.php" method="post">

        <?php

            //クリックジャッキング防止
            header('X-Frame-Options:Deny');

            //データベース接続　絶対パス
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');
            $pdo = GetDb();

            if (isset($_GET['service_start_id'])) {
                $button = "更新";

                $store_id = $_GET['store_id'];
                $service_start_id = $_GET['service_start_id'];
                echo '<input type="hidden"name="service_start_id"value="' . $service_start_id . '">';
                echo '<input type="hidden"name="store_id"value="' . $store_id . '">';

                $sql =
                    "SELECT * FROM `t_service_set` 
                WHERE`t_service_set`.`store_id` = :store_id
                AND `t_service_set`.`service_start_id` = :service_start_id
                ";
                $service_set_date = $pdo->prepare($sql);
                $service_set_date->bindParam(':service_start_id', $service_start_id);
                $service_set_date->bindParam(':store_id', $store_id);
                $service_set_date->execute();
                $get_service_set = $service_set_date->fetch(PDO::FETCH_ASSOC);


                $room_id_t              =   $get_service_set['room_id'];
                $service_id_t           =   $get_service_set['service_id'];
                $start_day              =   $get_service_set['start_day'];

                $start_time_base        =   $get_service_set['start_time_base'];
                $end_time_base          =   $get_service_set['end_time_base'];


                $teacher_base           =   $get_service_set['teacher_base'];
                $service_reserve_flag   =   $get_service_set['service_reserve_flag'];
                $note                   =   $get_service_set['note'];


                $sql = "SELECT * FROM `t_service_set_detail`
                 WHERE `store_id` = :store_id 
                 AND `service_start_id` = :service_start_id 
                 AND `service_nth` = '1'
                ";

                $service_set_detail_date = $pdo->prepare($sql);
                $service_set_detail_date->bindParam(':service_start_id', $service_start_id);
                $service_set_detail_date->bindParam(':store_id', $store_id);
                $service_set_detail_date->execute();

                $max_service_nth_sub = $service_set_detail_date->rowCount();



                /*****************************************************************************************************
                    for ($service_nth_sub_str = 0; $service_nth_sub_str < $max_service_nth_sub; $service_nth_sub_str++) {
                        $service_day_detail = $get_service_set_detail[$service_nth_sub_str][4];
                        $service_day_detail_num = strtotime($service_day_detail);
                        $service_day_detail_w[$service_nth_sub_str] = date("w", $service_day_detail_num);
                    }
                 *****************************************************************************************************/



                if ($max_service_nth_sub > 1) {
                    $week_select = "selected";
                    $day_select = "";
                    $disabled = "";
                } else {
                    $week_select = "";
                    $day_select = "";
                    $disabled = "disabled";
                }
            } else {
                $button = "登録";

                $store_id = $_GET['tid'];
                echo '<input type="hidden"name="store_id"value="' . $store_id . '">';

                $room_id_t              =   "";
                $service_id_t           =   "";
                $start_day              =   "";

                $start_time_base        =   "";
                $end_time_base          =   "";

                $teacher_base           =   "";
                $service_reserve_flag   =   "";
                $note                   =   "";

                $week_select            =   "";
                $day_select             =   "";
                $disabled               =   "";
            }





            echo "
            <h2 class='center'>サービス$button</h2>
            ";

            echo "<div class='form'>
            <ul>
            ";
            //サービスデータ
            $sql =
                "SELECT * FROM `m_service` 
            WHERE`store_id` = :store_id
            ";
            $service_date = $pdo->prepare($sql);
            $service_date->bindParam(':store_id', $store_id);
            $service_date->execute();
            $service_count = $service_date->rowCount();


            echo "
            <li>
            <label>サービス名:</label>
            <select required name='service'　id='service' class='input'>
            <option value='' selected>サービスをお選びください</option>
            ";
            if ($service_count > 0) {
                while ($get_service = $service_date->fetch(PDO::FETCH_ASSOC)) {

                    $service_name   =   $get_service['service_name'];
                    $service_title  =   $get_service['service_title'];
                    $service_id_m   =   $get_service['service_id'];

                    if ($service_id_m == $service_id_t) {
                        $service_select = 'selected';
                    } else {
                        $service_select = '';
                    }

                    echo "<optgroup label=$service_name>
                <option $service_select value=$service_id_m>$service_title</option>
                </optgroup>
                ";
                }
            }
            echo "</select>
            </li>";

            echo "<li><label>部屋:</label>";

            //部屋データ
            $sql =
                "SELECT * FROM `m_room` 
            WHERE`store_id`= :store_id
            ";
            $room_date = $pdo->prepare($sql);
            $room_date->bindParam(':store_id', $store_id);
            $room_date->execute();
            $room_count = $room_date->rowCount();


            echo "
            <select required name='room'　id='room' class='input'>
            <option value='' selected>部屋をお選びください</option>
            ";
            if ($room_count > 0) {
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

                </optgroup>
                ";
                }
            }
            echo "</select>
            </li>";

            echo "<li><label>開始日:</label>
            <input 
            required
            class='input'
            type='date'
            name='start_day'
            id='start_day'
            value='" . $start_day . "'
            >
            </li>";

            echo "
            <li>
            <label>間隔:</label>
           
            <select required id=\"select\" name=\"number\" class='input'style='width:50px;'>
            <option value='' selected>-</option>
            ";
            for ($a = 0; $a <= 6; $a++) {

                echo "
            <option value='" . $a . "'>$a</option>
            ";
            }
            echo "</select>

            <select required name=\"unit\" id=\"unit\" class='input'style='width:60px;'>
                
            <option value=''>単位</option>
            <option $day_select value='1'>日</option>
            <option $week_select value='7'>週</option>
            </select>
            <a>　1回</a>
            </li>";

            echo "<li>";
            $weekArr = array("日", "月", "火", "水", "木", "金", "土");
            for ($i = 0; $i <= 6; $i++) {

                echo "
                    <input $disabled  type='checkbox'value='" . $i . "' name='week[]'>$weekArr[$i]
                ";
            }

            if ($service_reserve_flag == "1") {
                $checked1 = "checked";
                $checked0 = "";
            } elseif ($service_reserve_flag == "0") {
                $checked1 = "";
                $checked0 = "checked";
            } else {
                $checked1 = "";
                $checked0 = "";
            }
            echo "</li>";
            echo "
            <li>
            <label>開始時間:</label>
            

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
            name='start_time_base'
            id='start_time_base'
            value='" . $start_time_base . "'
            >
            <datalist id='time_list'>
            ";

            for ($h = 0; $h < 24; $h++) {

                $m = array('00', '15', '30', '45');

                for ($position = 0; $position < 4; $position++) {
                    echo '<option value="' . $h . ':' . $m[$position] . '"></option>';
                }
            }

            echo "</datalist>
            <a>~</a>
           
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
            name='end_time_base'
            id='end_time_base'
            value='" . $end_time_base . "'
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


            //教師データ
            $teacher = "1";
            $sql =
                "SELECT * FROM `m_systemuser` 
            WHERE`teacher`= :teacher
            ";
            $teacher_date = $pdo->prepare($sql);
            $teacher_date->bindParam(':teacher', $teacher);
            $teacher_date->execute();
            $teacher_count = $teacher_date->rowCount();



            echo "<li>
            <label>担任講師:</label>
                <select  name='teacher_base'　id='teacher_base' class='input'>
                <option value='' selected>講師をお選びください</option>
                ";
            if ($teacher_count > 0) {

                while ($get_teacher = $teacher_date->fetch(PDO::FETCH_ASSOC)) {

                    $last_name   =   $get_teacher['last_name'];

                    $first_name  =   $get_teacher['first_name'];

                    $staff_id    =   $get_teacher['staff_id'];

                    if ($staff_id == $teacher_base) {
                        $teacher_select = 'selected';
                    } else {
                        $teacher_select = '';
                    }

                    echo "
                    <option $teacher_select value='" . $staff_id . "' >$last_name $first_name</option>
    
                    </optgroup>
                    ";
                }
            }
            echo "</select>
            </li>";
        ?>
        <li>
            <label>受付状態:</label>

            <label for="open" class="btn-radio">


                <?php
                echo "
                <input required $checked1 type=\"radio\" name=\"service_reserve_flag\" id=\"open\" value=\"1\">
                ";
                ?>

                <svg width="20px" height="20px" viewBox="0 0 20 20">
                    <circle cx="10" cy="10" r="9"></circle>
                    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                </svg>
                <span>開始</span>
            </label>

            <label for="close" class="btn-radio">


                <?php
                echo "
                <input required $checked0 type=\"radio\" name=\"service_reserve_flag\" id=\"close\" value=\"0\">
                ";
                ?>

                <svg width="20px" height="20px" viewBox="0 0 20 20">
                    <circle cx="10" cy="10" r="9"></circle>
                    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                </svg>
                <span>未開始</span>
            </label>
        </li>


        <?php
            echo "
            <li>
        <label>備考:</label>
        <textarea class='input' rows='1' name='note' id='note'>$note</textarea>
        ";
        ?>
        </li>
        </ul>
        </div>

        <input class='button' type='submit' value='<?= $button ?>' name='submit' style='float:left;margin-left:40%' onclick='return confirm("<?= $button ?>しますか？");'>
    </form>


    <form action="service_list.php" method="post">

        <?php
            echo '<input type="hidden"name="tid"value="' . $store_id . '">';
        ?>

        <input class="button" type="submit" value="戻る" style="float:left;margin-left:1%">
    </form>


<?php

        }
    }
?>
</body>
<br><br>
<label class="foot"> ©2020 株式会社ジェイテック</label>

</html>