<!DOCTYPE html>

<html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>

    <meta charset="utf-8">
    <title>店舗マスター削除</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
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


<?php
            /*************************************************************************************************
            共通内容２：データベースの接続(PDO)  && XSS対策 && clickjacking対策
             *************************************************************************************************/
            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

            //clickjacking対策
            header('X-FRAME-OPTIONS: DENY');

            /******************************************** 
            共通内容３：グローバル変数定義（もしあれば）
             ********************************************/
            $store_id = $_POST['store_id'];


            //部店舗マスター削除
            if (isset($_POST['delete'])) {

                try {
                    $pdo = GetDb();

                    $sql = 'DELETE FROM m_store  WHERE store_id = :store_id';
                    $stmt = $pdo->prepare($sql);
                    $array = array(':store_id' => $store_id);
                    $stmt->execute($array);

                    header('location:store_list.php');
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗：' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;
            }

            try {
                $pdo = GetDb();

                $sql = "SELECT * FROM  m_store WHERE store_id = :store_id ";
                $stmt = $pdo->prepare($sql);
                $arry = array(':store_id' =>  $store_id);
                $stmt->execute($arry);
                $result = 0;
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'データベースに接続失敗：' . $e->getMessage();
            }


            // 接続を閉じる
            $pdo = null;


?>
<h1><img src="img/logo3.png"></h1>

<body>
    <div class="center">
        <h2>店舗マスター削除</h2>



        <font color=red><br><a>以下の内容を削除しますがよろしいでしょうか？</a></font>

        <br><br>

        <form action="" method="POST">
            <?php
            //変数定義

            $store_id = $result["store_id"];
            $store_name = $result["store_name"];
            $station = $result["store_nearest_station"];
            $zipcode1 = $result["zipcode1"];
            $zipcode2 = $result["zipcode2"];
            $prefectures = $result["prefectures"];
            $ward = $result["ward"];
            $address = $result["address"];
            $tel = $result["store_telephone_number"];
            $fax = $result["store_fax_number"];

            ?>

            <div class="page">
                <br><a>店舗ID:</a>
                <?php echo $store_id; ?>
                <hr>


                <br><a>店舗名:</a>
                <?php echo $store_name; ?>
                <hr>


                <br><a>最寄駅:</a>
                <?php echo $station; ?>
                <hr>


                <br><a>郵便番号:</a>
                <?= $zipcode1 . "-" . $zipcode2 ?>
                <hr>


                <br><a>住所：</a>
                <?= $prefectures . $ward . $address ?>
                <hr>


                <br><a>電話番号：</a>
                <?= $tel ?>
                <hr>


                <br><a>FAX番号：</a>
                <?= $fax ?>
                <br><br>

            </div>

            <input class="button" type="submit" name="delete" value=" 削除" onclick='return confirm("削除しますか？");' />
            <input type="hidden" name="store_id" value="<?= $store_id ?>">
            <a href="<?php echo $href . "store_list.php" ?>"><input class="button" type="button" value="戻る"></a><br>

    </div>
    </form>
<?php

        }
    }
?>
</body>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>