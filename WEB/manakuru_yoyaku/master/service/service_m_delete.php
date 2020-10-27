<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>サービスマスター削除</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">

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

    <?php
            /*************************************************************************************************
        データベースの接続(PDO) && XSS対策 && clickjacking対策 
             *************************************************************************************************/
            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

            //XSS対策
            function html($str)
            {
                return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
            }

            //clickjacking対策
            header('X-FRAME-OPTIONS: DENY');

    ?>

    <?php
            $pageFlag = 0;

            if (!empty($_POST['delete'])) {
                $pageFlag = 1;
            }
    ?>

    <?php if ($pageFlag === 0) : ?>

        <body>
            <div class="center">
                <h2>サービスマスター削除</h2>
                <div class="page">
                    <?php
                    try {

                        $pdo = GetDb();
                        $sql = 'SELECT * FROM m_service JOIN m_store using(`store_id`) WHERE service_id = :service_id AND store_name = :store_name';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(':service_id' => $_POST["service_id"], ':store_name' => $_POST["store_name"]));
                        $result = 0;
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo 'データベースに接続失敗：<br>' . $e->getMessage();
                    }

                    // 接続を閉じる
                    $pdo = null;

                    $store_id = $result['store_id'];
                    $store_name = $result['store_name'];
                    $service_id = $result['service_id'];
                    $service_name = $result['service_name'];
                    $service_title = $result['service_title'];
                    $service_flg = $result['service_flg'];
                    $frequency = $result['frequency'];
                    $month = $result['month'];
                    $target = $result['target'];
                    $max_cnt = $result['max_cnt'];
                    $overview = $result['overview'];
                    $price = $result['price'];
                    $open_flg = $result['open_flg'];
                    $yoyaku_flg = $result['yoyaku_flg'];

                    echo '<br>';
                    echo '店舗:  ';
                    echo  $store_name;
                    echo '<hr><br>';

                    echo 'サービス名:  ';
                    echo $service_name;
                    echo '<hr><br>';

                    echo 'タイトル(講座名/職種):  ';
                    echo $service_title;
                    echo '<hr><br>';

                    echo 'サービス単位:  ';
                    if ($service_flg == 0) {
                        echo 'サービス単位';
                    } elseif ($service_flg == 1) {
                        echo '時間単位';
                    };
                    echo '<hr><br>';

                    echo 'コマ数:  ';
                    echo $frequency;
                    echo '<hr><br>';

                    echo '月数:  ';
                    echo $month;
                    echo '<hr><br>';

                    echo '対象者:  ';
                    echo $target;
                    echo '<hr><br>';

                    echo '最大予約者数:  ';
                    echo $max_cnt;
                    echo '<hr><br>';

                    echo '概要:  ';
                    echo $overview;
                    echo '<hr><br>';

                    echo '料金（円）:  ';
                    echo $price;
                    echo '<hr><br>';

                    echo '開始状態:  ';
                    if ($open_flg == 1) {
                        echo '開始中';
                    } elseif ($open_flg == 0) {
                        echo '停止中';
                    };
                    echo '<br><br>';


                    echo '<form method="POST" action="">';
                    echo '<input type="hidden" name="store_id" value="' . $store_id . '">';
                    echo '<input type="hidden" name="service_id" value="' . $service_id . '">';
                    ?>
                </div>
                <input class="button" type="submit" name="delete" value="削除" onclick="return confirm('削除してもよろしいですか？');" />
                <input class="button" type="button" onclick="history.back()" value="戻る">
                </form>
            </div>

        <?php endif; ?>



        <?php if ($pageFlag === 1) : ?>

            <?php

                $store_id = $_POST['store_id'];
                $service_id = $_POST['service_id'];

                try {

                    $pdo = GetDb();

                    $sql = "SELECT * FROM t_service_set WHERE store_id = :store_id AND service_id = :service_id";

                    $check = $pdo->prepare($sql);
                    $check->execute(array(':service_id' => $service_id, 'store_id' => $store_id));
                    $count = $check->rowCount();

                    if ($count != 0) {        //サービス設定に使われているか確認
                        echo "<div class='center'>
                        <div class='page'>
                        <br>                        
                        <font color=red><a>サービスが使用されています
                        <br>
                        削除出来ません</a></font>
                        <br><br>
                        </div>";
                    } else {


                        $sql = 'DELETE FROM  m_service  WHERE service_id = :service_id AND store_id =:store_id';
                        $stmt = $pdo->prepare($sql);
                        $array = array(':service_id' => $service_id, ':store_id' => $store_id);
                        $stmt->execute($array);

                        header('location:service_m_list.php');
                    }
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗：<br>' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;
            ?>
        <?php endif; ?>
<?php

        }
    }
?>
        </body>
        <br><br>
        <footer> ©2020 株式会社ジェイテック</footer>

</html>