<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <title>まなクル管理者側システム</title>
    <link rel="stylesheet" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/css/errorbox.css" type="text/css">
    <link rel="stylesheet" href="login.css" type="text/css">
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
</head>




<?php
session_start();
//POSTセキュリティー
include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");
//データベース接続
include('C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\DbManager.php');


include('C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\ValidationManager_login.php');


header('X-FRAME-OPTIONS: DENY');


$pageFlag = 0;
$error = validation($_POST);

if (isset($_POST["staff_id"]) && empty($error)) {
    $pageFlag = 1;
}

?>

<body>

    <?php if ($pageFlag === 0) : ?>
        <form method="post" action="">

            <div class="segment">
                <h1><img src="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/img/logo3.png"></h1>
            </div>

            <label>
                <input type="text" placeholder="ユーザーID" name="staff_id" />
            </label>
            <label>
                <input type="password" placeholder="パスワード" name="password" />
            </label>


            <button class="red" type="submit" name="login">ログイン</button>
            <br>
            <a href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/password_change.php">パスワード変更</a>
        </form>

    <?php endif; ?>



    <?php if (isset($_POST["staff_id"]) && isset($error)) : ?>
        <div class="errorbox">
            <ul>
                <?php foreach ($error as $value) : ?>
                    <li><?php echo $value; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php

    if (isset($_SESSION["error"])) {
        $error = $_SESSION["error"];
    ?>

        <div class="errorbox">
            <ul>
                <li>
                    <?= $error ?>
                </li>
            </ul>
        </div>
    <?php
    }

    unset($_SESSION["error"]);
    ?>





    <?php if ($pageFlag === 1) : ?>
        <!--ログイン処理-->
        <?php
        $staff_id = $_POST["staff_id"];
        $password = $_POST['password'];



        $pdo = GetDb();
        $sql = "SELECT * 
        FROM `m_systemuser`
        JOIN `m_store` 
        ON `m_systemuser`.`syozoku_store_id`=`m_store`.`store_id`
        WHERE `staff_id` = '$staff_id'";
        $login = $pdo->prepare($sql);
        $login->bindParam(":staff_id", $staff_id);
        $login->execute();
        $row = $login->fetch(PDO::FETCH_ASSOC);



        /**ユーザーIDがDB内に存在しているか確認**/
        if (!$row) {
            $_SESSION["error"] = "ユーザー存在しません";
            header("location: login.php");
        } else {

            if (password_verify($password, $row['password']) === TRUE) { //password_verifyが平文で入力された文字列と暗号化済みの文字列がマッチするかを確かめます
                session_regenerate_id(true); //session_idを新しく生成し、置き換える
                $_SESSION['STAFF_ID'] = $row['staff_id'];
                $_SESSION['LAST_NAME'] = $row['last_name'];
                $_SESSION['FIRST_NAME'] = $row['first_name'];
                $_SESSION['STORE_ID'] = $row['syozoku_store_id'];
                $_SESSION['STORE_NAME'] = $row['store_name'];
                $_SESSION['start'] = time();
                $_SESSION['expire'] = $_SESSION['start'] + (60 * 60);
                header('location:http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/main.php');
            } else {
                $_SESSION["error"] = "パスワードが正しくありません";
                header("location: login.php");
            }
        }
        ?>
    <?php endif; ?>

</body>



</html>