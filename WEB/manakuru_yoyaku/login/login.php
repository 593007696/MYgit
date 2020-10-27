<!DOCTYPE html>
<html>


<head>
    <link rel="stylesheet" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/css/style.css" type="text/css">
    <meta charset="utf-8">
    <title>ログイン</title>
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
</head>


<?php
/*************************************************************************************************
    共通内容２：データベースの接続(PDO) && バリデーションファイル && XSS対策 && clickjacking対策
 *************************************************************************************************/
//データベース接続
include('C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\DbManager.php');

//バリデーションファイルをimport
include('C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\ValidationManager_login.php');

//clickjacking対策
header('X-FRAME-OPTIONS: DENY');

include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");

$pageFlag = 0;
$error = validation($_POST);

if (!empty($_POST['login']) && empty($error)) {
    $pageFlag = 1;
}

?>

<?php if (!empty($_POST['login']) && !empty($error)) : ?>
    <ul>
        <?php foreach ($error as $value) : ?>
            <li><?php echo $value; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


<?php
session_start();

if (isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
    echo "<ul ><li><span >$error</span></li></ul>";
}

unset($_SESSION["error"]);
?>

<body>

    <h1><img src="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/img/logo3.png"></h1>


    <?php if ($pageFlag === 0) : ?>
        <!-- 入力画面 -->
        <!--ログインフォーム-->


        <div class="box">
            <a>ユーザーログイン</a>
            <br><br>
            <form name="login" method="post" action="">


                <input type="text" name="staff_id" placeholder="ユーザーID"></input>
                <br>
                <br>


                <input type="password" name="password" placeholder="パスワード"></input>
                <br>
                <br>
                <input class="button2" type="submit" name="login" value="ログイン"></input>


                <br>
                <br>
                <br>
                <a href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/password_change.php">パスワード変更</a>
                <br>
                <a href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/password_resert.php">パスワードリセット</a>
                <br>
            </form>
        </div>

    <?php endif; ?>



    <?php if ($pageFlag === 1) : ?>
        <!--ログイン処理-->
        <?php

        session_start();

        $pdo = GetDb();
        $sql = 'SELECT * 
    FROM m_systemuser 
    JOIN m_store 
    ON m_systemuser.syozoku_store_id=m_store.store_id 
    WHERE staff_id = :staff_id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':staff_id' => $_POST["staff_id"]));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $password = $_POST['password'];

        $error = "ユーザーID又はパスワードが間違っています";

        /**ユーザーIDがDB内に存在しているか確認**/
        if (!isset($row['staff_id'])) {
            $_SESSION["error"] = $error;
            header("location: login.php");
        }


        /*********************/
        /*パスワードの認証処理*/
        /********************/


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
            $_SESSION["error"] = $error;
            header("location: login.php");
        }

        ?>
    <?php endif; ?>

</body>
<br><br>
<a class="foot"> ©2020 株式会社ジェイテック</a>


</html>