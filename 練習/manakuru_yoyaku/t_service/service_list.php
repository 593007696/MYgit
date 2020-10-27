<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>サービス一覧</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/service.jquery.tablesorter.js"></script>
    <script type="text/javascript" src="js/security_lock .js"></script>

    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/checkbox.css" type="text/css">
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />


    <!--並び替え-->
    <script type="text/javascript">
        $(document).ready(function() {
            $("#list").tablesorter();
        });
    </script>

    <script>
        //店舗セレクトボックス切り替え値渡す
        function getid() {
            document.forms.store.submit();
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


<?php
            //POSTセキュリティー
            include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");
            //データベース接続
            include('C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\DbManager.php');
            //クリックジャッキング防止
            header('X-Frame-Options:Deny');
?>


<body>
    <br>

    <?php


            $pdo = GetDb();



            //店舗データ取る
            $sql = "SELECT * FROM m_store";
            $store_date = $pdo->prepare($sql);
            $store_date->execute();


            //初期tid POSTされない対策
            if (!isset($_POST["tid"])) {
                $tid = $_SESSION['STORE_ID'];
            } else {
                $tid = $_POST["tid"];
            }


            echo    "<form name='store'action='' method='POST'>";
            //echo    "<select name='tid'onchange='getid();'>";
            echo    "<select name='tid'>";
            echo    "<option value='0'>店舗選んでください</option>";
            while ($row = $store_date->fetch(PDO::FETCH_ASSOC)) {
                $store_name = $row['store_name'];
                $store_id   = $row['store_id'];

                //選定店舗セレクトボックスの中で固定
                if ($store_id == $tid) {
                    $selecet = 'selected';
                } else {
                    $selecet = '';
                }
                //店舗並び
                echo "<option $selecet value=$store_id >$store_name</option>";
            }
            echo    "</select>";
            echo    " <input class='button6' type='submit' value='GO'>";
            echo    "</form>";
    ?>






    <div class="center">
        <div class="page">

            <br>
            <h4>検索条件を指定してください</h4>

            <form method="post" action="">

                <input type="hidden" name="tid" value="<?= $tid ?>">

                <a>サービス名: </a>

                <input type="text" class="input" name="search_service_name">
                <br><br>
                <a>予約受付状態:</a>

                <label for="open" class="btn-radio">

                    <input type="radio" name="search_service_reserve_flag" value="1" id="open" 　>

                    <svg width="20px" height="20px" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="9"></circle>
                        <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                        <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                    </svg>
                    <span>開始</span>
                </label>

                <label for="close" class="btn-radio">

                    <input type="radio" name="search_service_reserve_flag" value="0" id="close" 　>

                    <svg width="20px" height="20px" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="9"></circle>
                        <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                        <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                    </svg>
                    <span>未開始</span>
                </label>

                <a>&emsp;&emsp;</a>
                <br><br>
                <input class="button2" type="submit" value="検索" name="search_start">

                <br><br>
            </form>

        </div>

    </div>





    <?php
            if (isset($_POST["search_start"])) :

                $search_service_name = isset($_POST['search_service_name']) ? "%" . $_POST['search_service_name'] . "%" : "";

                $search_service_reserve_flag = isset($_POST['search_service_reserve_flag']) ? $_POST['search_service_reserve_flag'] : "";

                $search_store_id = isset($_POST["tid"]) ? $_POST["tid"] : "";


                $search_service_name != "" ? $seach_date[] = "`m_service`.`service_name` LIKE :search_service_name" : "";
                $search_service_reserve_flag != "" ? $seach_date[] = "`t_service_set`.`service_reserve_flag`= :search_service_reserve_flag" : "";

                $sql_p1 = "SELECT * 
                FROM `t_service_set` 
                JOIN `m_service` USING(`service_id`,`store_id`) 
                WHERE `t_service_set`.`store_id` =  :search_store_id
                AND ";

                $sql_p2 = $sql_p2 = implode(" AND ", $seach_date);

                $sql = $sql_p1 . $sql_p2;

                $array = array(':search_store_id' => $search_store_id);

                $search_service_name != "" ? $array["search_service_name"] = $search_service_name : "";
                $search_service_reserve_flag != "" ? $array["search_service_reserve_flag"] = $search_service_reserve_flag : "";

                $service_set_date = $pdo->prepare($sql);
                $service_set_date->execute($array);

                $service_count = $service_set_date->rowCount();

                if ($service_count === 0) {

                    echo "<div class='center'>
                    <font color='red'> 該当するデータはありません </font>
                    </div>
                    ";
                } else {
                    echo "<div class='center'>
                    <a>検索結果 :$service_count 件</a>
                    </div>";
                }
            else :
                $sql = "SELECT * FROM `t_service_set` WHERE `store_id`= :tid";
                $service_set_date = $pdo->prepare($sql);
                $service_set_date->bindParam(":tid", $tid);
                $service_set_date->execute();

            endif
    ?>


    <label class="caption">サービス一覧</label>
    <br>
    <?php
            //店舗id nullの時登録ボタン表示しない

            if ($tid === "0") {
                $hidden = "hidden";
            } else {
                $hidden = "";
            }
            echo " <a $hidden href = 'service_register.php?tid=$tid'>
            <button class='button4' style='float:left;margin-left:1%'>新規</button>
            </a>";
    ?>

    <a href='service_calendar.php?store_id=<?= $tid ?>'>
        <input class='button2' type='button' value='カレンダー' style="float:left;margin-left:1%" <?= $hidden ?>>
    </a>


    <div class="scroll">

        <!--ヘッダー-->
        <?php
            //<<<eot eot;ヒアドキュメント
            $heta = <<<eot
                <table  id= "list" class= "zebra">
                
                <thead>
                <tr>
                <th $hidden class="pointer" title='並び替え'>NO.            <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>サービスID     <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>サービス名     <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>講座名         <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>部屋           <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>サービス開始日  <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>サービス終了日 <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>開始時間       <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>終了時間       <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>担任講師       <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>予約受付状態    <img src="img/filter.png"></th>
                <th $hidden class="pointer" title='並び替え'>備考欄       　<img src="img/filter.png"></th>
                <th $hidden >詳細                 </th>
                <th $hidden >変更                 </th>
                <th $hidden >削除                 </th>
                </tr>
                </thead>
                eot;

            echo $heta;

        ?>

        <!--リスト中身-->
        <?php
            echo "<tbody>";
            while ($row = $service_set_date->fetch(PDO::FETCH_ASSOC)) {
                $store_id               =   $row['store_id'];
                $service_id             =   $row['service_id'];
                $room_id                =   $row['room_id'];
                $start_day              =   $row['start_day'];
                $end_day                =   $row['end_day'];
                $start_time_base        =   $row['start_time_base'];
                $end_time_base          =   $row['end_time_base'];
                $teacher_base           =   $row['teacher_base'];
                $service_reserve_flag   =   $row['service_reserve_flag'];
                $note                   =   $row['note'];
                $service_start_id       =   $row['service_start_id'];

                //サービスデータ
                $sql = "SELECT * FROM `m_service` WHERE `service_id`= :service_id AND`store_id`= :store_id";
                $service_date = $pdo->prepare($sql);
                $service_date->bindParam(':service_id', $service_id);
                $service_date->bindParam(':store_id', $store_id);
                $service_date->execute();
                $get_service = $service_date->fetch(PDO::FETCH_ASSOC);

                $service_name   =   $get_service['service_name'];
                $service_title  =   $get_service['service_title'];

                //部屋データ
                $sql = "SELECT * FROM `m_room` WHERE `room_id`= :room_id AND`store_id`= :store_id";
                $room_date = $pdo->prepare($sql);
                $room_date->bindParam(':room_id', $room_id);
                $room_date->bindParam(':store_id', $store_id);
                $room_date->execute();
                $get_room = $room_date->fetch(PDO::FETCH_ASSOC);

                $room_name   =   $get_room['room_name'];

                if ($teacher_base != null) {
                    $sql = "SELECT * FROM `m_systemuser` WHERE`staff_id`= :teacher_base";
                    $teacher_date = $pdo->prepare($sql);
                    $teacher_date->bindParam(':teacher_base', $teacher_base);
                    $teacher_date->execute();
                    $get_teacher = $teacher_date->fetch(PDO::FETCH_ASSOC);


                    $teacher_base_l   =   $get_teacher['last_name'] . $get_teacher['first_name'];
                } else {
                    $teacher_base_l   = "";
                }

                if ($service_reserve_flag == 1) {
                    $service_reserve_flag_l = "開始";
                } elseif ($service_reserve_flag == 0) {
                    $service_reserve_flag_l = "<font color=red>未開始</font>";
                } else {
                    $service_reserve_flag_l = " ";
                }

                $start_day_number = strtotime($start_day);
                $start_day = date("Y-n-j", $start_day_number);

                $end_day_number = strtotime($end_day);
                $end_day = date("Y-n-j", $end_day_number);

                $start_time_base_number = strtotime($start_time_base);
                $start_time_base = date("G:i", $start_time_base_number);

                $end_time_base_number = strtotime($end_time_base);
                $end_time_base = date("G:i", $end_time_base_number);
                //行
                echo "
                <tr>
                <td class='num'> 
                $service_start_id     
                </td>
                <td class='num'> 
                $service_id     
                </td>
                <td > 
                $service_name
                </td>
                <td > 
                $service_title
                </td>
                <td > 
                $room_name
                </td>
                <td > 
                $start_day  
                </td>
                <td >         
                $end_day        
                </td>
                <td >
                $start_time_base
                </td>
                <td >
                $end_time_base
                </td>
                <td >
                $teacher_base_l
                </td>
                <td >
                $service_reserve_flag_l
                </td>
                <td >
                $note
                </td>

                <td>

                    <a href = 'service_detail_list.php?service_start_id=$service_start_id&store_id=$store_id&service_id=$service_id'>
                        <button title='詳細設定' class='button2'>詳細</button>
                    </a>

                </td>

                <td>
                    <a href = 'service_register.php?service_start_id=$service_start_id&store_id=$store_id'>
                        <button title='情報変更' class='button4'>更新</button>
                    </a>
                </td>

                <td>
                    <a href = 'service_delete.php?service_start_id=$service_start_id&store_id=$store_id'>
                        <button title='サービス削除' class='button5'>削除</button>
                    </a>
                </td>
                </tr>
            ";
            }
            echo "</tbody></table>";
        ?>
    </div>
    <?php

            $pdo = null;
    ?>
    <br>
    <a href="../main.php"><input class="button" type="button" value="戻る"></a>

<?php

        }
    }
?>
</body>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>