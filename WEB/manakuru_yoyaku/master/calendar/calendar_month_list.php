<!DOCTYPE html>
<html>

<head>
    <title>カレンダー(月単位)</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/checkbox.css" type="text/css">

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
            include('../../common/php/DbManager.php');


            $year = $_GET['year'];
            $month = $_GET['month'];
            $store_name = $_SESSION['store_name'];

            //月末日を取得
            $last_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);

            //月の最大日数
            if ($last_day == 31 || $last_day == 30) {

                $month_max = $last_day;
            } else if ($last_day == 28 || $last_day == 29) {   //2月の判別

                $month_max = cal_days_in_month(CAL_GREGORIAN, 2, $year);
            }

            $now_days = strtotime(date("$year-$month-$last_day"));

            $year_save = $year;
            $calendar = array();
            $j = 0;

            //先月のカレンダー
            $last_month = date('n', $now_days - $month_max * 24 * 60 * 60);

            //来月のカレンダー
            $next_month = date('n', $now_days + $month_max * 24 * 60 * 60);

            $year_val = $year;

            $year = $year_save;

            if (($year_val % 4 == 0) && ($year_val % 100 != 0)) {   //閏年の判定

                $next_month = date('n', $now_days + $month_max  + 1 * 24 * 60 * 60);
            } else {  //閏年後のズレを修正

                $next_month = date('n', $now_days + $month_max + 2 * 24 * 60 * 60);
            }





            if ($month == 12 && $next_month == 1) {

                $next_year = ($year + 1);
                $last_year = $year;
            } else if ($month == 1 && $last_month == 12) {

                $last_year = ($year - 1);
                $next_year = $year;
            } else {

                $last_year = $year;
                $next_year = $year;
            }


            //カレンダーのタイトルを設定　
            $title = date('$year年$month月');

            //年，月を画面に表示
            /*echo $year.'年';
            echo $month.'月';*/

            $store = $_GET['sid'];

            $title_name = $store_name . '店';

            $title = $year . '年' . $month . '月';

            echo "<h3 id='store'>$title_name</h3>";
            echo "<h3>$title</h3>";
            //echo "<br>";
            //echo "<br>";


            $error = "error";
            try {

                $pdo = GetDb();

                // 月末日までループ
                for ($day = 1; $day < $last_day + 1; $day++) {

                    // 曜日を取得
                    $week = date('w', mktime(0, 0, 0, $month, $day, $year));

                    //where day month year をキーとして holiday_flgを取得
                    $query = "SELECT holiday_flg FROM m_calendar WHERE year=? AND month=? AND day=? AND store_id = ?";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindparam(1, $year, PDO::PARAM_INT);
                    $stmt->bindparam(2, $month, PDO::PARAM_INT);
                    $stmt->bindparam(3, $day, PDO::PARAM_INT);
                    $stmt->bindparam(4, $store, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt;


                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                        $holiday_flg[$day] = $row['holiday_flg'];
                        $error = $row['holiday_flg'];
                    }
                    /*if (!$result) {
        die('クエリーが失敗しました。'.mysql_error());
    }*/
                    // 1日の場合
                    if ($day == 1) {

                        // 1日目の曜日までをループ
                        for ($start_day = 1; $start_day <= $week; $start_day++) {

                            // 前半に空文字をセット
                            $calendar[$j]['days'] = '';
                            $j++;
                        }
                    }

                    // 配列に日付をセット
                    $calendar[$j]['days'] = $day;
                    $j++;

                    // 月末日の場合
                    if ($day == $last_day) {

                        // 月末日から残りをループ
                        for ($end_day = 1; $end_day <= 6 - $week; $end_day++) {

                            // 後半に空文字をセット
                            $calendar[$j]['days'] = '';
                            $j++;
                        }
                    }
                }
            } catch (PDOException $e) {
                echo 'データベースに接続失敗：' . $e->getMessage();
            }


            if ($error != "error") {
?>

    <body>
        <a href="calendar_master.php?sid=<?php echo $store ?>&year=<?php echo $year ?>"><button class="button" type="button">戻る</button></a><br><br>

        <div class="center">

            <a id="lastmonth" href="calendar_month_list.php?month=<?php echo $last_month ?>&year=<?php echo $last_year ?>&sid=<?php echo $store ?>">
                <<</a> <a id="nextmonth" href="calendar_month_list.php?month=<?php echo $next_month ?>&year=<?php echo $next_year ?>&sid=<?php echo $store ?>">>>
            </a>


        </div>
        <br>


        <table class="zebra">
            <tr>
                <th id="sun">日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th id="sat">土</th>
            </tr>

            <tr>
                <?php $cnt = 0;
                foreach ($calendar as $key => $value) :
                ?>
                    <?php
                    if ($value['days'] != null) {

                        if ($holiday_flg[$value['days']] == "0") {
                            echo '<td bgcolor="#f0f8ff">';
                        } else {
                            echo '<td bgcolor="#EFB4C5">';
                        }
                    } else {
                        echo '<td bgcolor="#f0f8ff">';
                    }
                    ?>


                    <?php
                    $cnt++;
                    //Query Stringを使って日をリンクしている
                    echo '<a href=calendar_date_update.php?year=' . $year . '&month=' . $month . '&day=' . $value['days'] . '&sid=' . $store . '>' . $value['days'] . '</a>';
                    ?>
                    <?php
                    if ($value['days'] != null) {
                        echo '<br>';
                        if ($holiday_flg[$value['days']] == "0") {
                            echo "<font color ='black'>営</font>";
                        } else {
                            echo "<font color ='red'>休</font>";
                        }
                    }
                    ?>
                    </td>

                    <?php if ($cnt == 7) : ?>
            </tr>

            <tr>
        <?php
                        $cnt = 0;
                    endif;
                endforeach;
        ?>
            </tr>
        </table>


    <?php
            } else {

                echo '<div class="center"
    <a>データ存在しません</a>
    <br><br>';

                echo '<button class="button" type="button" onclick="history.back()">戻る</button></div>';
            }
    ?>
    </body>
    <br><br>
<?php

        }
    }

?>
<footer> ©2020 株式会社ジェイテック</footer>

</html>