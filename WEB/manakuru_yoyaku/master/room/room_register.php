<!DOCTYPE html>
<html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>
    <meta charset="utf-8">
    <title>部屋マスタ新規登録</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/form.css" type="text/css">
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
            //POSTセキュリティー
            include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");
            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

            //バリデーションファイルをimport
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/ValidationManager_room.php');

            //clickjacking対策
            header('X-FRAME-OPTIONS: DENY');


            /******************************************** 
            共通内容３：グローバル変数定義（もしあれば）
             ********************************************/
            //グローバル変数定義
            date_default_timezone_set('Asia/Tokyo'); //timezon設定
            $updated_date  = date("Y/m/d H:i:s");


            $pageFlag = 0;
            $error = validation($_POST);

            if (!empty($_POST['confirm']) && empty($error)) {
                $pageFlag = 1;
            }


            if (!empty($_POST['register'])) {
                $pageFlag = 2;
            }
?>


<!-- 登録ボタンが空ではなく、且つエラーが空ではなかったら -->
<?php

            $room_name = "";
            $seat = "";
            $loan = "";
            if (!empty($_POST['confirm']) && !empty($error)) :
?>
    <ul class="error">
        <!-- $errorは連想配列なのでforeachで分解していく -->
        <?php foreach ($error as $value) : ?>
            <!-- 分解したエラー文をlistの中に表示していく -->
            <li><?php echo $value; ?></li>
        <?php endforeach; ?>
    </ul>
<?php
                $room_name = $_POST['room_name'];
                $seat = $_POST['seat'];
                $loan = isset($_POST['loan']) ? $_POST['loan'] : "";
            endif;
?>


<?php

            if (isset($_SESSION["error"])) {
                $error = $_SESSION["error"];
                echo "<ul ><li><a>$error</a></li></ul>";
            }

            unset($_SESSION["error"]);
?>


<?php

            $store_id = $_POST["store_id"];
            try {
                $pdo = GetDb();


                $sql = "SELECT * FROM m_store WHERE store_id = :store_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':store_id', $store_id);
                $stmt->execute();


                //レコード件数
                $row_count = $stmt->rowCount();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $store_name = $row["store_name"];
            } catch (PDOException $e) {
                echo 'データベースに接続失敗：' . $e->getMessage();
            }

            // 接続を閉じる
            $pdo = null;

?>
<h1><img src="img/logo3.png"></h1>

<body>
    <?php if ($pageFlag === 0) : ?>


        <div class="center">
            <h2>部屋マスタ新規登録</h2>
            <h3><?php echo $store_name; ?></h3>
        </div>
        <div class="form">
            <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

                <ul>

                    <input type="hidden" name="store_name" value="<?php echo $store_name ?>">
                    <input type="hidden" name="store_id" value="<?php echo $store_id ?>">

                    <li>
                        <label>部屋名:</label>
                        <input value="<?= $room_name ?>" class="input" type="text" name="room_name" placeholder="">
                    </li>



                    <li><label>席数:</label>
                        <input value="<?= $seat ?>" class="input" type="text" name="seat" placeholder="">
                    </li>



                    <li>
                        <label>貸出可否:</label>

                        <label for="loan_ok" class="btn-radio">

                            <input type="radio" name="loan" value="1" id="loan_ok" <?php echo $loan == "1" ? "checked" : ""; ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>可</span>
                        </label>


                        <label for="loan_ng" class="btn-radio">

                            <input type="radio" name="loan" value="0" id="loan_ng" <?php echo $loan == "0" ? "checked" : ""; ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>否</span>
                        </label>

                    </li>

                </ul>
        </div>
        <div class="center">
            <input type="submit" name="confirm" value="登録" class="button" style="float:left; margin-left:45%">
            </form>

            <form action="<?php echo $href . "room_list.php" ?>" method="post">
                <input type="hidden" name="store_name" value="<?php echo $store_name ?>">
                <input class="button" type="submit" value="戻る" style="float:left;margin-left:1%">
            </form>
        </div>
</body>
<div class="foot">
    <a>©2020 株式会社ジェイテック</a>
</div>


<?php endif; ?>



<?php if ($pageFlag === 1) : ?>
    <?php
                //変数定義
                $store_id = $_POST['store_id'];
                $store_name = $_POST['store_name'];
                $room_name = $_POST['room_name'];
                $seat = $_POST['seat'];
                $loan = $_POST['loan'];
                $error = "部屋名" . $room_name . "は既に登録されました";


                //DB内のroom_nameと重複しているかチェック
                try {

                    $pdo = GetDb();

                    $sql = "SELECT room_name 
                    FROM m_room 
                    WHERE room_name = :room_name
                    AND store_id    = :store_id
                    ";
                    $stmt = $pdo->prepare($sql);
                    $array = array(
                        'store_id' => $store_id,
                        ':room_name' => $room_name
                    );
                    $stmt->execute($array);

                    $error_count = $stmt->rowCount();

    ?>　

    <h2 class="center">部屋マスタ新規登録確認</h2>

    <?php
                    if ($error_count > 0) {

    ?>
        <div class="center">
            <label class="error"><?= $error ?></label>
            <br><br>
            <input type="button" onclick="history.back()" value="戻る" class="button">

            <br>

        </div>
        <label class="foot">©2020 株式会社ジェイテック</label>
    <?php
                    } else {
    ?>
        <div class="center">
            <font color="red">以下の内容を新規登録しますがよろしいでしょうか？</font>
        </div>

        </div>
        <div class="page">
            <div class="center">
                <?php

                        echo "<h3>$store_name</h3>";



                        echo    "<hr><a>部屋名:</a>";
                        echo     $room_name . "<hr>";


                        echo    "<a>席数:</a>";
                        echo     $seat . "<hr>";

                        echo    "<a>貸出可否：</a>";
                        if ($loan == 1) {
                            echo '可';
                        } else {
                            echo '否';
                        }
                ?>
                <br><br>
            </div>
        </div>

        <div class="center">
            <form action="" method="POST">
                <input type="hidden" name="store_id" value="<?= $store_id; ?>">
                <input type="hidden" name="room_name" value="<?= $room_name; ?>">
                <input type="hidden" name="seat" value="<?= $seat; ?>">
                <input type="hidden" name="loan" value="<?= $loan; ?>">
                <input type="hidden" name="store_name" value="<?= $store_name; ?>">
                <input type="submit" name="register" value="確定" class="button" onclick='return confirm("登録しますか？");'>
                <input type="button" onclick="history.back()" value="戻る" class="button">
            </form>
        </div>


        </body>

        <footer>©2020 株式会社ジェイテック</footer>
    <?php
                    }
    ?>

<?php

                } catch (PDOException $e) {
                    echo 'データベースに接続失敗：' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;
?>
<?php endif; ?>


<?php if ($pageFlag === 2) : ?>
    <?php
                //変数定義
                $store_id = $_POST['store_id'];
                $room_name = $_POST['room_name'];
                $seat = $_POST['seat'];
                $loan = $_POST['loan'];
                $store_name = $_POST['store_name'];

                //部屋の新規登録
                try {
                    $pdo = GetDb();



                    $sql =
                        "SELECT max(room_id) 
                        FROM m_room
                        WHERE store_id = :store_id
                        ";
                    $maxid = $pdo->prepare($sql);
                    $maxid->bindParam(':store_id', $store_id);
                    $maxid->execute();

                    $get_max_id = $maxid->fetch(PDO::FETCH_NUM);
                    $room_id = $get_max_id[0] + 1;



                    $sql =
                        'INSERT INTO m_room (room_id,store_id,room_name,seat,loan,updated_date) 
                    value (:room_id,:store_id,:room_name,:seat,:loan,:updated_date) ';
                    $stmt = $pdo->prepare($sql);
                    $array = array(
                        'room_id' => $room_id,
                        ':store_id' => $store_id,
                        ':room_name' => $room_name,
                        ':seat' => $seat,
                        ':loan' => $loan,
                        ':updated_date' => $updated_date
                    );
                    $stmt->execute($array);

                    header('location:room_list.php?store_name=' . $store_name);
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗：' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;
    ?>
<?php endif; ?>





<?php

        }
    }
?>


</html>