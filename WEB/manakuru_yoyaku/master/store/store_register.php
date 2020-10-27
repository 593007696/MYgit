<!DOCTYPE html>

<html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>
    <meta charset="utf-8">
    <title>店舗マスター新規登録</title>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <script src="../../../js/ajaxzip3.js" charset="UTF-8"></script>
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

<body>
    <?php
            //POSTセキュリティー
            include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");
            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

            //バリデーションファイルをimport
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/ValidationManager_store.php');

            //clickjacking対策
            header('X-FRAME-OPTIONS: DENY');



            $pageFlag = 0;
            $error = validation($_POST);

            if (!empty($_POST['confirm']) && empty($error)) {
                $pageFlag = 1;
            }

            if (!empty($_POST['register'])) {
                $pageFlag = 2;
            }

    ?>




    <?php if ($pageFlag === 0) : ?>
        <!-- 入力画面 -->


        <div class="center">
            <h2>店舗マスター新規登録</h2>
        </div>
        <?php
                $store_name = "";
                $station = "";
                $zipcode1 = "";
                $zipcode2 = "";
                $prefectures = "";
                $ward = "";
                $address = "";
                $tel = "";
                $fax = "";

                if (!empty($_POST['confirm']) && !empty($error)) : ?>

            <ul class="error">
                <?php foreach ($error as $value) : ?>
                    <li><?php echo $value; ?></li>
                <?php endforeach; ?>
            </ul>

        <?php
                    $store_name = $_POST['store_name'];
                    $station = $_POST['station'];
                    $zipcode1 = $_POST['zipcode1'];
                    $zipcode2 = $_POST['zipcode2'];
                    $prefectures = $_POST['prefectures'];
                    $ward = $_POST['ward'];
                    $address = $_POST['address'];
                    $tel = $_POST['tel'];
                    $fax = $_POST['fax'];
                endif; ?>



        <form method="post" action="">

            <div class="form">
                <ul>
                    <li><label>店舗名:</label>
                        <input value="<?= $store_name ?>" class="input" type="text" name="store_name" placeholder="例：まなクル○○駅店">
                    </li>


                    <li><label>最寄駅:</label>
                        <input value="<?= $station ?>" class="input" type="text" name="station" placeholder="例：○○駅">
                    </li>


                    <li><label>郵便番号:</label>
                        <input value="<?= $zipcode1 ?>" style="width: 50px;" class="input" type="text" name="zipcode1" placeholder="上三位">
                        <a>－</a>
                        <input value="<?= $zipcode2 ?>" style="width: 85px;" class="input" type="text" name="zipcode2" placeholder="下四位" onKeyUp="AjaxZip3.zip2addr('zipcode1','zipcode2','prefectures','ward','address');">
                    </li>


                    <li><label>都道府県:</label>
                        <input value="<?= $prefectures ?>" class="input" type="text" name="prefectures" placeholder="例：東京都">
                    </li>


                    <li><label>区市町村:</label>
                        <input value="<?= $ward ?>" class="input" type="text" name="ward" placeholder="例：○○区">
                    </li>


                    <li><label>住所:</label>
                        <input value="<?= $address ?>" class="input" type="text" name="address" placeholder="例：○○-○○丁目-○○番-○○○○">
                    </li>


                    <li><label>電話番号:</label>
                        <input value="<?= $tel ?>" class="input" type="tel" name="tel" placeholder="10～11桁の半角数字">
                    </li>


                    <li><label>FAX番号:</label>
                        <input value="<?= $fax ?>" class="input" type="text" name="fax" placeholder="10～11桁の半角数字">
                    </li>



                </ul>
            </div>
            <div class="center">
                <input class="button" type="submit" name="confirm" value="登録">

                <a href="<?php echo $href . "store_list.php" ?>"><input class="button" type="button" value="戻る"></a><br>
            </div>
        </form>
    <?php endif; ?>



    <?php if ($pageFlag === 1) : ?>
        <?php
                //変数定義

                $store_name = $_POST['store_name'];
                $station = $_POST['station'];
                $zipcode1 = $_POST['zipcode1'];
                $zipcode2 = $_POST['zipcode2'];
                $prefectures = $_POST['prefectures'];
                $ward = $_POST['ward'];
                $address = $_POST['address'];
                $tel = $_POST['tel'];
                $fax = $_POST['fax'];

                //DB内のstore_nameと重複しているかチェック
                try {

                    $pdo = GetDb();

                    $sql = "select store_name from m_store where store_name = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$store_name]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!isset($row['store_name'])) {  //DB内のroom_nameと重複しているかチェック 
        ?>　
        <div class="center">
            <h2>店舗マスター新規登録確認</h2>


            <font color=red><a>以下の内容を新規登録しますがよろしいでしょうか？</a></font>
            <br><br>
            <div class="page">
                <?php
                        echo    "<br>店舗名:";
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

            <form action="" method="POST">
                <input type="hidden" name="store_name" value="<?= $store_name; ?>">
                <input type="hidden" name="station" value="<?= $station; ?>">
                <input type="hidden" name="zipcode1" value="<?= $zipcode1; ?>">
                <input type="hidden" name="zipcode2" value="<?= $zipcode2; ?>">
                <input type="hidden" name="prefectures" value="<?= $prefectures; ?>">
                <input type="hidden" name="ward" value="<?= $ward; ?>">
                <input type="hidden" name="address" value="<?= $address; ?>">
                <input type="hidden" name="tel" value="<?= $tel; ?>">
                <input type="hidden" name="fax" value="<?= $fax; ?>">
                <input class="button" type="submit" name="register" value="確定" onclick='return confirm("登録しますか？");'>
                <input class="button" type="button" onclick="history.back()" value="戻る">
            </form>
        </div>
<?php
                    } else {
                        echo '<br>';
                        echo '<font color="RED"><strong>既に登録された</strong></font><br>';
                        echo '<input type="button" onclick="history.back()" value="戻る">';
                    }
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗:' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;
?>
<?php endif; ?>


<?php if ($pageFlag === 2) : ?>
    <?php
                //変数定義
                $store_name = $_POST['store_name'];
                $station = $_POST['station'];
                $zipcode1 = $_POST['zipcode1'];
                $zipcode2 = $_POST['zipcode2'];
                $prefectures = $_POST['prefectures'];
                $ward = $_POST['ward'];
                $address = $_POST['address'];
                $tel = $_POST['tel'];
                $fax = $_POST['fax'];
                $created_date  = date("Y/m/d H:i:s");

                try {
                    $pdo = GetDb();

                    $sql = "SELECT max(store_id) FROM m_store ";
                    $maxid = $pdo->prepare($sql);
                    $maxid->execute();

                    $get_max_id = $maxid->fetch(PDO::FETCH_NUM);
                    $store_id = $get_max_id[0] + 1;




                    $sql = 'INSERT INTO m_store 
                    (store_id,
                    store_name,
                    store_nearest_station,
                    zipcode1,
                    zipcode2,
                    prefectures,
                    ward,
                    address,
                    store_telephone_number,
                    store_fax_number,
                    created_date) 
                    value (:store_id,
                    :store_name,
                    :station,
                    :zipcode1,
                    :zipcode2,
                    :prefectures,
                    :ward,
                    :address,
                    :tel,
                    :fax,
                    :created_date) ';
                    $stmt = $pdo->prepare($sql);
                    $array = array(
                        ':store_id' =>  $store_id,
                        ':store_name' => $store_name,
                        ':station' => $station,
                        ':zipcode1' => $zipcode1,
                        ':zipcode2' => $zipcode2,
                        ':prefectures' => $prefectures,
                        ':ward' => $ward,
                        ':address' => $address,
                        ':tel' => $tel,
                        ':fax' => $fax,
                        ':created_date' => $created_date
                    );
                    $stmt->execute($array);

                    header('location:store_list.php');
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗:' . $e->getMessage();
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
<br>
<footer> ©2020 株式会社ジェイテック</footer>


</html>