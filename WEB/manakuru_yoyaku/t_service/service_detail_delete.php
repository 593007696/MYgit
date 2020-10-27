<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <title>サービス詳細削除</title>
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

    <?php
            //クリックジャッキング防止
            header('X-Frame-Options:Deny');

            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');
            $pdo = GetDb();
    ?>
    <div class="center">
        <?php

            echo "<h2>サービス詳細削除</h2>";

            echo "<div class='page'>
            <br>";

            $store_id           = $_GET['store_id'];
            $service_start_id   = $_GET['service_start_id'];
            $service_nth        = $_GET['service_nth'];
            $service_nth_sub    = $_GET['service_nth_sub'];


            $sql = "DELETE FROM `t_service_set_detail` 
            WHERE `store_id` = :store_id
            AND `service_start_id` = :service_start_id
            AND `service_nth` = :service_nth
            AND `service_nth_sub` = :service_nth_sub
            ";

            $delete = $pdo->prepare($sql);
            $delete->bindParam(':service_start_id', $service_start_id);
            $delete->bindParam(':store_id', $store_id);
            $delete->bindParam(':service_nth_sub', $service_nth_sub);
            $delete->bindParam(':service_nth', $service_nth);
            $delete->execute(
                array(
                    ':service_start_id' => $service_start_id,
                    ':store_id' => $store_id,
                    ':service_nth_sub' => $service_nth_sub,
                    ':service_nth' => $service_nth
                )
            );
            if ($delete->rowCount() > 0) {
                echo "サービス詳細削除しました。<br><br>";
            } else {
                echo  "削除失敗: " . $sql . "<br>" . $pdo->errorCode();
                print_r($pdo->errorInfo());
            };

            $pdo = null;

        ?>

    </div>

    <form action="service_list.php" method="post">

        <?php
            echo '<input type="hidden"name="tid"value="' . $store_id . '">';
        ?>

        <input class="button3" type="submit" value="サービス一覧へ">
    </form>

    </div>
<?php

        }
    }
?>
</body>

<label class="foot"> ©2020 株式会社ジェイテック</label>

</html>