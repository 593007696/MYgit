<!DOCTYPE html>

<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<html>

<head>
        <meta charset="UTF-8">
        <title>会員退会</title>
        <link rel="stylesheet" href="<?php echo $href . "css/style.css" ?>" type="text/css">
        <link rel="stylesheet" href="<?php echo $href . "css/table.css" ?>" type="text/css">
        <link rel="stylesheet" href="<?php echo $href . "css/input.css" ?>" type="text/css">
        <link rel="stylesheet" href="<?php echo $href . "css/border.css" ?>" type="text/css">
        <link rel="stylesheet" href="<?php echo $href . "css/page.css" ?>" type="text/css">
        <link rel="stylesheet" href="<?php echo $href . "css/radio.css" ?>" type="text/css">
        <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
        <h1><img src="<?php echo $href . "img/logo3.png" ?>"></h1>
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

<body>




        <?php
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

                        if (!empty($_POST['con'])) {
                                $pageFlag = 1;
                        }
        ?>

        <?php if ($pageFlag === 0) : ?>

                <body>
                        <div class="center">
                                <h2>会員退会</h2>
                                <div class="page">
                                        <?php
                                        try {

                                                $pdo = GetDb();
                                                $sql = 'SELECT * FROM m_member WHERE member_id = :member_id';
                                                $stmt = $pdo->prepare($sql);
                                                $stmt->execute(array(':member_id' => $_POST["member_id"]));
                                                $result = 0;
                                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        } catch (PDOException $e) {
                                                echo 'データベースに接続失敗：<br>' . $e->getMessage();
                                        }

                                        // 接続を閉じる
                                        $pdo = null;

                                        $store_id = $result['store_id'];
                                        $member_id = $result['member_id'];
                                        $last_name = $result['last_name'];
                                        $first_name = $result['first_name'];
                                        $sei = $result['sei'];
                                        $mei = $result['mei'];
                                        $gender = $result['gender'];

                                        $birthday = $result['birthday'];
                                        $age = $result['age'];
                                        $zipcode1 = $result['zipcode1'];
                                        $zipcode2 = $result['zipcode2'];
                                        $prefectures = $result['prefectures'];
                                        $ward = $result['ward'];
                                        $address = $result['address'];
                                        $tel = $result['tel'];
                                        $job = $result['job'];
                                        $email = $result['email'];

                                        echo '<br>';
                                        echo '店舗ID:<br>';
                                        echo  $store_id;
                                        echo '<hr><br>';

                                        echo '会員ID:<br>';
                                        echo  $member_id;
                                        echo '<hr><br>';

                                        echo '姓:<br>';
                                        echo $last_name;
                                        echo '<hr><br>';

                                        echo '名:<br>';
                                        echo $first_name;
                                        echo '<hr><br>';

                                        echo 'セイ:<br>';
                                        echo $sei;
                                        echo '<hr><br>';

                                        echo 'メイ:<br>';
                                        echo $mei;
                                        echo '<hr><br>';

                                        echo '性別:<br>';
                                        if ($gender == 1) {
                                                echo '男性';
                                        } elseif ($gender == 2) {
                                                echo '女性';
                                        } elseif ($gender == 9) {
                                                echo 'その他';
                                        };
                                        echo '<hr><br>';

                                        echo '生年月日:<br>';
                                        echo $birthday;
                                        echo '<hr><br>';

                                        echo '年齢:<br>';
                                        echo $age;
                                        echo '<hr><br>';

                                        echo '郵便番号:<br>';
                                        echo $zipcode1 - $zipcode2;
                                        echo '<hr><br>';

                                        echo '都道府県:<br>';
                                        echo $prefectures;
                                        echo '<hr><br>';

                                        echo '区市町村:<br>';
                                        echo $ward;
                                        echo '<hr><br>';

                                        echo '住所:<br>';
                                        echo $address;
                                        echo '<hr><br>';

                                        echo '電話番号:<br>';
                                        echo $tel;
                                        echo '<hr><br>';

                                        echo '職業:<br>';
                                        if ($job == 1) {
                                                echo '学生';
                                        } elseif ($job == 2) {
                                                echo '会社員';
                                        } elseif ($job == 9) {
                                                echo 'その他';
                                        };
                                        echo '<hr><br>';

                                        echo 'メール:<br>';
                                        echo $email;
                                        echo '<br><br>';



                                        echo '<form method="POST" action="">';
                                        echo '<input type="hidden" name="member_id" value="' . $member_id . '">';

                                        ?>

                                </div>
                                <input class="button" type="submit" name="con" value="退会" onclick="return confirm('退会しますか?');">

                                <input class="button" type="button" onclick="history.back()" value="戻る">

                        </div>
                        </form>
                <?php endif; ?>



                <?php if ($pageFlag === 1) : ?>

                        <?php
                                date_default_timezone_set("Asia/ToKyo");

                                $member_id = $_POST['member_id'];
                                $withdrawal_date = date("Y-m-d H:i:s");
                                try {

                                        $pdo = GetDb();
                                        $sql = 'UPDATE `m_member` 
                                        SET `withdrawal_date`= :withdrawal_date
                                        WHERE  `member_id` = :member_id ';
                                        $stmt = $pdo->prepare($sql);
                                        $array = array(
                                                ':member_id' => $member_id,
                                                ':withdrawal_date' => $withdrawal_date,
                                        );
                                        $stmt->execute($array);

                                        header('location:http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/member/member_list.php');
                                } catch (PDOException $e) {
                                        echo 'データベースに接続失敗：<br>' . $e->getMessage();
                                }

                                // 接続を閉じる
                                $pdo = null;
                        ?>
                <?php endif; ?>


                </body>
<?php

                }
        }
?>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>