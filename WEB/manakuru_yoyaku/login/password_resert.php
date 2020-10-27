<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <meta charset="utf-8">
    <title>パスワードリセット</title>
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
</head>


<body>
<?php
/*************************************************************************************************
    共通内容２：データベースの接続(PDO) && バリデーションファイル && XSS対策 && clickjacking対策
 *************************************************************************************************/
//データベース接続
include('../common/php/DbManager.php');

//バリデーションファイルをimport
include('../common/php/ValidationManager_pwresert.php');

//clickjacking対策
header('X-FRAME-OPTIONS: DENY');

//XSS対策
function html($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if (!empty($_POST)) {
    foreach ($_POST as $key => $value) {
        $clean[$key] =  html($value);
    }
}

$pageFlag = 0;
$error = validation($_POST);

if (!empty($_POST['resert']) && empty($error)) {
    $pageFlag = 1;
}

?>

<?php if (!empty($_POST['resert']) && !empty($error)) : ?>
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

if (isset($_SESSION["message"])) {
    $message = $_SESSION["message"];
    echo "<ul><li><span >$message</span></li></ul>";
}

unset($_SESSION["error"]);
unset($_SESSION["message"]);
?>

<h1><img src="img/logo3.png"></h1>


<?php if ($pageFlag === 0) : ?>


    <!--パスワード変更フォーム-->
    <div class="center">
        <h2>パスワードリセット</h2>
        <form method="post" action="">
            <a for="staff_id">ユーザーID</a><br>
            <input type="text" name="staff_id" placeholder="ユーザーID" value="<?php if (!empty($clean['staff_id'])) {
                                                                                echo $clean['staff_id'];
                                                                            } ?>"></input>
            <br>


            <a for="last_name">姓</a><br>
            <input type="text" name="last_name" placeholder="ユーザー姓" value="<?php if (!empty($clean['last_name'])) {
                                                                                echo $clean['last_name'];
                                                                            } ?>"></input>
            <br>


            <a for="first_name">名</a><br>
            <input type="text" name="first_name" placeholder="ユーザー名" value="<?php if (!empty($clean['first_name'])) {
                                                                                echo $clean['first_name'];
                                                                            } ?>"></input>
            <br>


            <a for="new_password">新しいパスワード</a><br>
            <input type="password" name="new_password" placeholder="新しいパスワード "></input>
            <br>


            <a for="confirm_password">パスワードの確認</a><br>
            <input type="password" name="confirm_password" placeholder="パスワードの確認"></input>
            <br>
            <br>

            <input type="submit" class="button" name="resert" title="resert" value="リセット"></input>

            <a href="login.php"><input type="button" class="button" title="return" value="戻る"></input>
            </a>

        </form>
    </div>

<?php endif; ?>

<?php if ($pageFlag === 1) : ?>
    <!--パスワード変更処理-->
    <?php

    $staff_id = $_POST['staff_id'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $error = "ユーザーID又はパスワードが間違っています";
    $message = "パスワード変更しました";

    //timezon設定
    date_default_timezone_set('Asia/Tokyo');

    try {
        $pdo = GetDb();

        /*********************************************/
        /*ユーザ情報の認証処理（DB内でユーザーIDを検索）*/
        /********************************************/
        $sql = "SELECT * FROM m_systemuser WHERE staff_id = :staff_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':staff_id', $staff_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        /**********************************************************/
        /******ユーザー姓名、パスワード確認後パスワードの更新処理******/
        /*********************************************************/

        // 入力したパスワードとハッシュ化されたパスワードの検証
        if ($last_name == $row['last_name'] && $first_name == $row['first_name']) {

            $new_password_hash =  password_hash($new_password, PASSWORD_DEFAULT); //パスワードの暗号化

            $sql = "UPDATE m_systemuser SET password = :new_password_hash WHERE staff_id = :staff_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':new_password_hash', $new_password_hash);
            $stmt->bindParam(':staff_id', $staff_id);
            $result = $stmt->execute();

            $_SESSION["message"] = $message;
            header("location: password_resert.php");
        } else {
            $_SESSION["error"] = $error;
            header("location: password_resert.php");
        }
    } catch (PDOException $e) {
        echo 'データベースに接続失敗：' . $e->getMessage();
    }
    // 接続を閉じる
    $pdo = null;

    ?>
<?php endif; ?>
</body>
<br><br><br>
    <footer> ©2020 株式会社ジェイテック</footer>

</html>
