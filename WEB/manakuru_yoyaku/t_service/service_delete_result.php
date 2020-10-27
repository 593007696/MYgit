<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <title>サービス削除結果</title>
    <script type="text/javascript" src="js/security_lock .js"></script>

    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/checkbox.css" type="text/css">
    <link rel="stylesheet" href="css/form.css" type="text/css">
    <h1><img src="img/logo3.png"></h1>
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
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

<?php
            //POSTセキュリティー
            include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");
?>



<body>
    <div class="center">

        <h2>サービス削除結果</h2>

        <div class="page">
            <br>
            <?php
            //クリックジャッキング防止
            header('X-Frame-Options:Deny');

            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');
            $pdo = GetDb();



            $service_start_id = "";
            $service_start_id = $_POST['service_start_id'];
            $store_id = "";
            $store_id = $_POST['store_id'];


            $sql = "DELETE FROM `t_service_set` 
                WHERE `t_service_set`.`store_id` = :store_id  
                AND `t_service_set`.`service_start_id` = :service_start_id
                ";
            $delete = $pdo->prepare($sql);
            $delete->bindParam(':service_start_id', $service_start_id);
            $delete->bindParam(':store_id', $store_id);
            $delete->execute(
                array(
                    ':service_start_id' => $service_start_id,
                    ':store_id' => $store_id
                )
            );

            if ($delete->rowCount() > 0) {
                echo  "サービス削除しました。";
            } else {
                echo  "削除失敗: " . "<br>" . $pdo->errorCode();
                print_r($pdo->errorInfo());
            }

            $sql_2 = "DELETE FROM `t_service_set_detail` 
        WHERE `store_id` = :store_id  
        AND `service_start_id` = :service_start_id";

            $delete_2 = $pdo->prepare($sql_2);
            $delete_2->bindParam(':service_start_id', $service_start_id);
            $delete_2->bindParam(':store_id', $store_id);
            $delete_2->execute(
                array(
                    ':service_start_id' => $service_start_id,
                    ':store_id' => $store_id
                )
            );

            if ($delete_2->rowCount() > 0) {
            } else {
                echo  "詳細削除失敗: " . "<br>" . $pdo->errorCode();
                print_r($pdo->errorInfo());
            }



            $pdo = null;
            ?>
            <br>
            <br>
        </div>
        <form action="service_list.php" method="post">

            <?php
            echo '<input type="hidden"name="tid"value="' . $store_id . '">';
            ?>

            <input class="button3" type="submit" value="登録一覧へ">
        </form>
    </div>
<?php

        }
    }
?>
</body>
<br><br>
<div class="foot">
    <a> ©2020 株式会社ジェイテック</a>
</div>

</html>