<!DOCTYPE html>

<html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>
    <meta charset="utf-8">
    <title>店舗マスター更新</title>

    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <script src="../../common/js/ajaxzip3.js" charset="UTF-8"></script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
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

<h1><img src="img/logo3.png"></h1>

<?php
            //POSTセキュリティー
            include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");
            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

            //バリデーションファイルをimport
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/ValidationManager_store.php');

            //clickjacking対策
            header('X-FRAME-OPTIONS: DENY');



            /******************************************** 
                共通内容３:グローバル変数定義（もしあれば）
             ********************************************/
            date_default_timezone_set('Asia/Tokyo'); //timezon設定
            $updated_date  = date("Y/m/d H:i:s");
            $store_id = $_POST["store_id"];





            $pageFlag = 0;
            $error = validation($_POST);

            if (isset($_POST['confirm']) && empty($error)) {
                $pageFlag = 1;
            }

            if (isset($_POST['update'])) {
                $pageFlag = 2;
            }
?>




<body>

    <?php if ($pageFlag === 0) : ?>

        <?php
                try {
                    $pdo = GetDb();

                    $sql = "SELECT * FROM  m_store   WHERE store_id = :store_id ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(':store_id' =>  $store_id));
                    $result = 0;
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗:' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;

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

        <div class="center">
            <h2>店舗マスター更新</h2>
        </div>

        <?php if (isset($_POST['confirm']) && isset($error)) : ?>
            <ul class="error">
                <?php foreach ($error as $value) : ?>
                    <li><?php echo $value; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="form">
            <form action="" method="POST">
                <ul>
                    <li>
                        <label>店舗ID:</label>
                        <?= $store_id ?>
                        <input type="hidden" name="store_id" value="<?= $store_id ?>">
                    </li>

                    <li><label>店舗名:</label>
                        <input type="text" class="input" name="store_name" autocomplete="off" value="<?php echo $store_name; ?>">
                    </li>



                    <li><label>最寄駅:</label>
                        <input type="text" class="input" name="station" autocomplete="off" value="<?php echo $station; ?>">
                    </li>


                    <li><label>郵便番号:</label>
                        <input style="width: 50px;" type="text" class="input" name="zipcode1" autocomplete="off" value="<?php echo $zipcode1; ?>">
                        <a>－</a>
                        <input style="width: 85px;" type="text" class="input" name="zipcode2" autocomplete="off" value="<?php echo $zipcode2; ?>">
                    </li>



                    <li><label>都道府県:</label>
                        <input type="text" class="input" name="prefectures" value="<?php echo $prefectures; ?>">
                    </li>


                    <li><label>区市町村:</label>
                        <input type="text" class="input" name="ward" value="<?php echo $ward; ?>">
                    </li>


                    <li><label>住所:</label>
                        <input type="text" class="input" name="address" value="<?php echo $address; ?>">
                    </li>


                    <li><label>電話番号:</label>
                        <input type="text" class="input" name="tel" value="<?php echo $tel; ?>">
                    </li>



                    <li><label>FAX番号:</label>
                        <input type="text" class="input" name="fax" value="<?php echo $fax; ?>">
                    </li>
                </ul>

        </div>

        <div class="center">
            <input class="button" type="submit" name="confirm" value="更新">
            </form>

            <a href="<?php echo $href . "store_list.php" ?>">
                <input class="button" type="button" value="戻る">
                <a>
        </div>


    <?php endif; ?>


    <?php if ($pageFlag === 1) : ?>

        <div class="center">
            <h2>更新内容確認</h2>


            <font color=red><a>以下の内容を更新しますがよろしいでしょうか？</a></font>
            <br><br>

            <div class="page">
                <?php
                $store_id = $_POST["store_id"];
                $store_name = $_POST["store_name"];
                $station = $_POST["station"];
                $zipcode1 = $_POST["zipcode1"];
                $zipcode2 = $_POST["zipcode2"];
                $prefectures = $_POST["prefectures"];
                $ward = $_POST["ward"];
                $address = $_POST["address"];
                $tel = $_POST["tel"];
                $fax = $_POST["fax"];

                echo    "<br>店舗ID:";
                echo     $store_id . "<hr><br>";

                echo    "店舗名:";
                echo     $store_name . "<hr><br>";

                echo    "最寄駅:";
                echo     $station . "<hr><br>";

                echo    "郵便番号:";
                echo     $zipcode1 . "-" . $zipcode2 . "<hr><br>";

                echo    "都道府県:";
                echo     $prefectures . "<hr><br>";

                echo    "区/市/町/村:";
                echo     $ward . "<hr><br>";

                echo    "住所:";
                echo     $address . "<hr><br>";

                echo    "電話番号:";
                echo     $tel . "<hr><br>";

                echo    "FAX番号:";
                echo     $fax . "<br><br>";

                ?>
            </div>
            <br>
            <form action="" method="POST">
                <input type="hidden" name="store_id" value="<?= $store_id; ?>">
                <input type="hidden" name="store_name" value="<?= $store_name; ?>">
                <input type="hidden" name="station" value="<?= $station; ?>">
                <input type="hidden" name="zipcode1" value="<?= $zipcode1; ?>">
                <input type="hidden" name="zipcode2" value="<?= $zipcode2; ?>">
                <input type="hidden" name="prefectures" value="<?= $prefectures; ?>">
                <input type="hidden" name="ward" value="<?= $ward; ?>">
                <input type="hidden" name="address" value="<?= $address; ?>">
                <input type="hidden" name="tel" value="<?= $tel; ?>">
                <input type="hidden" name="fax" value="<?= $fax; ?>">
                <input class="button" type="submit" name="update" value="確定" onclick='return confirm("更新しますか？");'>
                <input class="button" type="button" onclick="history.back()" value="戻る">
        </div>
        </form>

    <?php endif; ?>


    <?php if ($pageFlag === 2) : ?>

        <?php

                try {
                    $pdo = GetDb();

                    $sql = "SELECT * FROM  m_store   WHERE store_id = :store_id ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(':store_id' =>  $store_id));
                    $result = 0;
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗:' . $e->getMessage();
                }

                //変数定義
                $store_name = $_POST['store_name'];
                $station = $_POST['station'];
                $zipcode1 = $_POST['zipcode1'];
                $zipcode2 = $_POST['zipcode2'];
                $prefectures = $_POST['prefectures'];
                $ward = $_POST['ward'];
                $address = $_POST['address'];
                $map = $prefectures . $ward . $address;
                $tel = $_POST['tel'];
                $fax = $_POST['fax'];

                try {
                    $pdo = GetDb();

                    $sql = 'UPDATE m_store SET 
                    store_name = :store_name,
                    store_nearest_station = :store_nearest_station,
                    zipcode1 = :zipcode1,
                    zipcode2 = :zipcode2,
                    prefectures = :prefectures,
                    ward = :ward, 
                    address = :address,
                    store_telephone_number = :store_telephone_number,
                    store_fax_number =:store_fax_number,
                    updated_date=:updated_date
                    WHERE store_id = :store_id';

                    $stmt = $pdo->prepare($sql);
                    $array = array(
                        ':store_name' => $store_name,
                        ':store_nearest_station' => $station,
                        ':zipcode1' => $zipcode1,
                        ':zipcode2' => $zipcode2,
                        ':prefectures' => $prefectures,
                        ':ward' => $ward,
                        ':address' => $address,
                        ':store_telephone_number' => $tel,
                        ':store_fax_number' => $fax,
                        ':updated_date' => $updated_date,
                        ':store_id' => $store_id
                    );

                    $stmt->execute($array);

                    header('location:store_list.php');
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗:' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;




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