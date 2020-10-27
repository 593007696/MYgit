<!DOCTYPE html>
<html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>
    <link rel="stylesheet" href="css/style.css" type="text/css">

    <link rel="stylesheet" href="css/page.css" type="text/css">

    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
    <meta charset="utf-8" />
    <title>ユーザー削除画面</title>
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

            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');
            if (isset($_POST['delete'])) {
                try {
                    $pdo = GetDb();

                    $sql = 'DELETE FROM m_systemuser WHERE staff_id = :staff_id';
                    $stmt = $pdo->prepare($sql);

                    $array = array(':staff_id' => $_POST['staff_id']);
                    $stmt->execute($array);

                    header('location:systemuser_list.php');
                } catch (PDOException $e) {
                    echo 'エラーが発生しました。:' . $e->getMessage();
                }
            } else { ?>

    <!--DBから情報のセレクト-->
    <?php

                try {
                    $pdo = GetDb();

                    // set parameters and execute
                    $stmt = $pdo->prepare('SELECT * FROM m_systemuser WHERE staff_id = :staff_id');
                    $stmt->execute(array(':staff_id' => $_POST["staff_id"]));
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

        <!--更新フォーム-->
        <div id="form" class="center">
            <h2>ユーザー削除</h2>
            <form method="post" action="">

                <div class="page">
                    <br><a>ユーザーID：</a>
                    <!--読み取り専用-->
                    <?php if (!empty($result['staff_id'])) echo (htmlspecialchars($result['staff_id'], ENT_QUOTES, 'UTF-8')); ?>




                    <hr><br><a>姓：</a>
                    <?php if (!empty($result['last_name'])) echo (htmlspecialchars($result['last_name'], ENT_QUOTES, 'UTF-8')); ?>




                    <hr><br><a>名：</a>
                    <?php if (!empty($result['first_name'])) echo (htmlspecialchars($result['first_name'], ENT_QUOTES, 'UTF-8')); ?>


                    <hr><br><a>性別</a>
                    <?php if (!empty($result['gender'])) {
                        if ($result['gender'] == 1) {
                            echo '男性';
                        } elseif ($result['gender'] == 2) {
                            echo '女性';
                        } elseif ($result['gender'] == 9) {
                            echo 'その他';
                        }
                    } ?>




                    <hr><br><a>生年月日：</a>
                    <?php if (!empty($result['birthday'])) echo (htmlspecialchars($result['birthday'], ENT_QUOTES, 'UTF-8')); ?>





                    <hr><br><a>年齢：</a>
                    <?php if (!empty($result['age'])) echo (htmlspecialchars($result['age'], ENT_QUOTES, 'UTF-8')); ?>




                    <hr><br><a>入社日：</a>
                    <?php if (!empty($result['date_company'])) echo (htmlspecialchars($result['date_company'], ENT_QUOTES, 'UTF-8')); ?>




                    <hr><br><a>雇用形態：</a>
                    <?php if (!empty($result['type_emloyment'])) {
                        if ($result['type_emloyment'] == 1) {
                            echo '正社員';
                        } elseif ($result['type_emloyment'] == 2) {
                            echo 'アルバイト';
                        } elseif ($result['type_emloyment'] == 9) {
                            echo 'その他';
                        }
                    } ?>




                    <hr><br><a>役割：</a>
                    <?php if (!empty($result['role'])) {
                        if ($result['role'] == 1) {
                            echo '管理者';
                        } elseif ($result['role'] == 2) {
                            echo '講師';
                        } elseif ($result['role'] == 3) {
                            echo '受付';
                        } elseif ($result['role'] == 9) {
                            echo 'その他';
                        }
                    } ?>




                    <hr><br><a>講師：</a>
                    <?php if (!empty($result['teacher'])) {
                        if ($result['teacher'] == 1) {
                            echo '講師可';
                        } else {
                            echo '講師不可';
                        }
                    } ?>





                    <hr><br><a>郵便番号：</a>
                    <?php if (!empty($result['zipcode1'])) echo (htmlspecialchars($result['zipcode1'], ENT_QUOTES, 'UTF-8')); ?> － <?php if (!empty($result['zipcode2'])) echo (htmlspecialchars($result['zipcode2'], ENT_QUOTES, 'UTF-8')); ?>




                    <hr><br><a>都道府県：</a>
                    <?php if (!empty($result['prefectures'])) echo (htmlspecialchars($result['prefectures'], ENT_QUOTES, 'UTF-8')); ?>




                    <hr><br><a>区/市/町/村：</a>
                    <?php if (!empty($result['ward'])) echo (htmlspecialchars($result['ward'], ENT_QUOTES, 'UTF-8')); ?>




                    <hr><br><a>住所：</a>
                    <?php if (!empty($result['address'])) echo (htmlspecialchars($result['address'], ENT_QUOTES, 'UTF-8')); ?>




                    <hr><br><a>電話番号：</a>
                    <?php if (!empty($result['tel'])) echo (htmlspecialchars($result['tel'], ENT_QUOTES, 'UTF-8')); ?>




                    <hr><br><a>メールアドレス：</a>
                    <?php if (!empty($result['email'])) echo (htmlspecialchars($result['email'], ENT_QUOTES, 'UTF-8')); ?>
                    <br>
                    <br>
                </div>

                <?php
                $staff_id = $_POST['staff_id'];
                echo '<input type="hidden" name="staff_id" value= "' . $staff_id . '" >';
                ?>

                <input class="button" type="submit" name="delete" value=" 削除" onclick='return confirm("削除しますか？");' />
                <a href="<?php echo $href . "systemuser_list.php" ?>">
                    <input type="button" class="button" title="return" value="戻る">
                </a>

            </form>
        </div>

    </body>
    <br><br>
    <footer> ©2020 株式会社ジェイテック</footer>

</html>

<?php }
        }
    }
?>