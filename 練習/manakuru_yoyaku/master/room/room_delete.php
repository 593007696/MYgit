<!DOCTYPE html>
<html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>
    <meta charset="utf-8">
    <title>部屋マスター削除</title>
    <link rel="stylesheet" href="<?php echo $href . "css/style.css" ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo $href . "css/border.css" ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo $href . "css/page.css" ?>" type="text/css">
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
            echo "一定時間で操作をしませんでした。ログインし直してください。<br><a href='http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/login.php'>ログインへ</a>";
        } else {

            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/SessionManager.php');


    ?>
</div>
<h1><img src="img/logo3.png"></h1>

<body>
    <?php
            /*************************************************************************************************
            共通内容２：データベースの接続(PDO)  && XSS対策 && clickjacking対策
             *************************************************************************************************/
            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

            /******************************************** 
            共通内容３：グローバル変数定義（もしあれば）
             ********************************************/
            $store_id = $_POST["store_id"];


            $room_id = $_POST["room_id"];

            //部屋の削除
            if (isset($_POST['delete'])) {
                $store_name = $_POST["store_name"];
                try {
                    $pdo = GetDb();

                    $sql = 'DELETE FROM m_room  WHERE room_id = :room_id AND store_id = :store_id';
                    $stmt = $pdo->prepare($sql);
                    $array = array(':room_id' => $room_id, 'store_id' => $store_id);
                    $stmt->execute($array);

                    header('location:room_list.php?store_name=' . $store_name);
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗：' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;
            }

            try {
                $pdo = GetDb();

                $sql = "SELECT * 
                FROM  m_room  
                JOIN m_store 
                using(`store_id`) 
                WHERE room_id = :room_id 
                AND store_id = :store_id ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':room_id' =>  $room_id, 'store_id' => $store_id));
                $result = 0;
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'データベースに接続失敗：' . $e->getMessage();
            }
            $store_name = $result["store_name"];
            // 接続を閉じる
            $pdo = null;

            try {
                $pdo = GetDb();

                $sql = "SELECT * 
                FROM `t_service_set` 
                WHERE `store_id` = :store_id 
                AND `room_id` = :room_id ";
                $check = $pdo->prepare($sql);
                $check->execute(array(':room_id' =>  $room_id, 'store_id' => $store_id));

                $count = $check->rowCount();
            } catch (PDOException $error) {
                echo 'データベースに接続失敗：' . $error->getMessage();
            }
            if ($count != 0) {

                echo "<div class='center'>
                <div class='page'>
                <br>
                <font color=red><a>部屋使用されています
                <br>
                削除することはできません</a></font>
               <br><br>
                </div>
                <form action='" . $href . "room_list.php' method='post'>
                <input type='hidden'name='store_name'value='" . $store_name . "'>
                <input class='button' type='submit' value='戻る'>
                </form>
              
                </div>";
            } else {


    ?>


        <div class="center">
            <h2>部屋マスター削除</h2>
            <a>
                <font color=red>以下の内容を削除してよろしいでしょうか？</font>
            </a>


            <form action="" method="POST">

                <?php
                //変数定義
                $store_id = $result["store_id"];
                $store_name = $result["store_name"];
                $room_id = $result["room_id"];
                $room_name = $result["room_name"];
                $seat = $result["seat"];
                $loan = $result["loan"];
                ?>

                <div class="page">


                    <h3>
                        <?php echo $store_name; ?>
                    </h3>


                    <hr><br><a>部屋ID:<a>
                            <?php echo $room_id; ?>

                            <hr><br><a>部屋名:<a>
                                    <?= $room_name ?>

                                    <hr><br><a>席数:<a>
                                            <?= $seat ?>

                                            <hr><br><a>貸出可否:<a>
                                                    <?php
                                                    if ($loan == 1) {
                                                        echo "可";
                                                    } else {
                                                        echo "否";
                                                    }
                                                    ?>
                                                    <br><br>
                </div>
        </div>



        <input class="button" type="submit" name="delete" value=" 削除" onclick='return confirm("削除しますか");' style="float:left; margin-left:40%">
        <input type="hidden" name="room_id" value="<?= $room_id ?>">
        <input type="hidden" name="store_id" value="<?= $store_id ?>">
        <input type="hidden" name="store_name" value="<?= $store_name ?>">

        </form>

        <form action="<?php echo $href . "room_list.php" ?>" method="post">
            <input type="hidden" name="store_name" value="<?php echo $store_name ?>">
            <input class="button" type="submit" value="戻る" style="float:left;margin-left:1%">
        </form>





<?php }
        }
    }
?>
</body>
<br><br>
<br><br>
<br><br>
<div class="foot3">
    <a> ©2020 株式会社ジェイテック</a>
</div>

</html>