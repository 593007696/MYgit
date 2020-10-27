<!DOCTYPE html>
<html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>
    <title>ユーザーマスター新規登録</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/form.css" type="text/css">
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
    <!--生年月日&&入社日-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/B_form.js"></script>
    <script type="text/javascript" src="js/form.js"></script>

    <!--年齢-->
    <script type="text/javascript" src="js/age.js"></script>


    <!--郵便番号-->
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <script src="../js/ajaxzip3.js" charset="UTF-8"></script>

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
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/ValidationManager_systermuser.php');

            //clickjacking対策
            header('X-FRAME-OPTIONS: DENY');




            $pageFlag = 0;
            //1ページで入力→確認→完了まで表示する場合
            //pageFlagという変数を使って遷移させる

            $error = validation($_POST);
            //バリデーションのエラー表示を受け取る変数

            if (!empty($_POST['confirm']) && empty($error)) {
                $pageFlag = 1;
            }
            //確認ボタンが空じゃない且つ、エラーメッセージが空だったらページを変える


            if (!empty($_POST['register'])) {
                $pageFlag = 2;
            }

    ?>

    <?php
            $staff_id = "";
            $last_name = "";
            $first_name = "";
            $gender = "";
            $B_year = "";
            $B_month = "";
            $B_date = "";

            $age = "";
            $year = "";
            $month = "";
            $date = "";

            $syozoku_store_id = "";
            $type_employment = "";;
            $role = "";
            $teacher = "";
            $zipcode1 = "";
            $zipcode2 = "";
            $prefectures = "";;
            $ward = "";
            $address = "";
            $tel = "";
            $email = "";
            $emailConfirm = "";
            $password = "";
            $passwordConfirm = "";

            if (!empty($_POST['confirm']) && !empty($error)) : ?>
        <ul class="error">

            <?php foreach ($error as $value) : ?>

                <li><?php echo $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php


                $staff_id = $_POST['staff_id'];
                $last_name = $_POST['last_name'];
                $first_name = $_POST['first_name'];
                $gender = isset($_POST['gender']) ? $_POST['gender'] : "";


                $syozoku_store_id = $_POST['syozoku_store_id'];
                $type_employment = isset($_POST['type_employment']) ? $_POST['type_employment'] : "";
                $role = isset($_POST['role']) ? $_POST['role'] : "";
                $teacher = isset($_POST['teacher']) ? $_POST['teacher'] : "";
                $zipcode1 = $_POST['zipcode1'];
                $zipcode2 = $_POST['zipcode2'];
                $prefectures = $_POST['prefectures'];
                $ward = $_POST['ward'];
                $address = $_POST['address'];
                $tel = $_POST['tel'];
                $email = $_POST['email'];
                $emailConfirm = $_POST['emailConfirm'];
                $password = $_POST['password'];
                $passwordConfirm = $_POST['passwordConfirm'];





            endif; ?>



    <?php if ($pageFlag === 0) : ?>
        <!-- 入力画面 -->

        <?php
                try {
                    $pdo = GetDb();

                    //店舗セレクトボックス
                    $sql = "SELECT * FROM m_store ";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    //レコード件数
                    $row_count = $stmt->rowCount();

                    //連想配列で取得
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $rows[] = $row;
                    }
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗:' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;

        ?>

        <div class="center">
            <h2>新規登録</h2>
        </div>
        <form method="post" action="">

            <div class="form">

                <ul>


                    <li><label>姓</label>
                        <input type="text" class="input" name="last_name" maxlength="10" placeholder="漢字及び英文字" value="<?= $last_name ?>">

                    </li>

                    <li><label>名</label>
                        <input type="text" class="input" name="first_name" maxlength="10" placeholder="漢字及び英文字" value="<?= $first_name ?>">
                    </li>




                    <li>

                        <label>性別</label>


                        <label for="male" class="btn-radio">


                            <input type="radio" name="gender" value="1" id="male" <?php if ($gender == "1") {
                                                                                        echo "checked";
                                                                                    } ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>男</span>
                        </label>


                        <label for="female" class="btn-radio">


                            <input type="radio" name="gender" value="2" id="female" <?php if ($gender == "2") {
                                                                                        echo "checked";
                                                                                    } ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>女</span>
                        </label>


                        <label for="other" class="btn-radio">


                            <input type="radio" name="gender" value="9" id="other" <?php if ($gender == "9") {
                                                                                        echo "checked";
                                                                                    } ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>その他</span>
                        </label>
                    </li>



                    <li>
                        <label>生年月日</label>
                        <select id="B_year" name="B_year" class="input" style="width: 60px;">
                            <option value="0">年</option>
                        </select>
                        <select id="B_month" name="B_month" class="input" style="width: 45px;">
                            <option value="0">月</option>
                        </select>
                        <select id="B_date" name="B_date" class="input" style="width: 45px;">
                            <option value="0">日</option>
                        </select>
                    </li>


                    <li><label>年齢</label>
                        <input type="text" class="input" id="age" name="age" readonly="readonly" placeholder="ここは入力できません">

                    </li>

                    <li><label>入社日</label>
                        <select id="year" name="year" class="input" style="width: 60px;">
                            <option value="0">年</option>
                        </select>
                        <select id="month" name="month" class="input" style="width: 45px;">
                            <option value="0">月</option>
                        </select>
                        <select id="date" name="date" class="input" style="width: 45px;">
                            <option value="0">日</option>
                        </select>
                    </li>

                    <li><label>所属店舗</label>
                        <select id="store" name="syozoku_store_id" class="input">";
                            <option value='0'>店舗を選んでください</option>
                            <?php
                            if ($row_count != 0) {
                                foreach ($rows as $row) {
                                    $store_name = $row['store_name'];
                                    $store_id   = $row['store_id'];
                                    $selected  = $syozoku_store_id == $store_id ? "selected" : "";
                                    echo " <option " . $selected . " value='" . $store_id . "'>" . $store_name . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </li>

                    <li>
                        <label>雇用形態</label>



                        <label for="full_time" class="btn-radio">

                            <input type="radio" name="type_employment" value="1" id="full_time" <?php echo $type_employment == "1" ? "checked" : ""; ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>正社員</span>
                        </label>



                        <label for="part_time" class="btn-radio">

                            <input type="radio" name="type_employment" value="2" id="part_time" <?php echo $type_employment == "2" ? "checked" : ""; ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>アルバイト</span>
                        </label>



                        <label for="type_other" class="btn-radio">

                            <input type="radio" name="type_employment" value="9" id="type_other" <?php echo $type_employment == "9" ? "checked" : ""; ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>その他</span>
                        </label>
                    </li>


                    <li>
                        <label>役割</label>

                        <label for="admin" class="btn-radio">

                            <input type="radio" name="role" value="1" id="admin" <?php echo $role == "1" ? "checked" : ""; ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>管理者</span>
                        </label>



                        <label for="teacher" class="btn-radio">

                            <input type="radio" name="role" value="2" id="teacher" <?php echo $role == "2" ? "checked" : ""; ?>>
                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>講師</span>
                        </label>


                        <label for="role_other" class="btn-radio">

                            <input type="radio" name="role" value="9" id="role_other" <?php echo $role == "9" ? "checked" : ""; ?>>
                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>受付</span>
                        </label>

                    </li>


                    <li>
                        <label>講師可否</label>

                        <label for="teacher_y" class="btn-radio">

                            <input type="radio" name="teacher" value="1" id="teacher_y" <?php echo $teacher == "1" ? "checked" : ""; ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>講師可</span>
                        </label>

                        <label for="teacher_n" class="btn-radio">

                            <input type="radio" name="teacher" value="0" id="teacher_n" <?php echo $teacher == "0" ? "checked" : ""; ?>>

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>講師不可</span>
                        </label>
                    </li>




                    <!-- ▼郵便番号入力フィールド(3桁+4桁) -->
                    <li><label>郵便番号</label>
                        <input style="width: 50px;" type="text" class="input" name="zipcode1" placeholder="上三位" value="<?= $zipcode1 ?>">
                        <a>－</a>
                        <input style="width: 85px;" type="text" class="input" name="zipcode2" placeholder="下四位" value="<?= $zipcode2 ?>" onKeyUp="AjaxZip3.zip2addr('zipcode1','zipcode2','prefectures','ward','address');">
                    </li>

                    <!-- ▼住所入力フィールド(都道府県) -->
                    <li><label>都道府県</label>
                        <input type="text" class="input" name="prefectures" placeholder="例:東京都" value="<?= $prefectures ?>">
                    </li>

                    <!-- ▼住所入力フィールド(都道府県以降の住所) -->
                    <li><label>区市町村</label>
                        <input type="text" class="input" name="ward" placeholder="例：○○区" value="<?= $ward ?>">
                    </li>

                    <li><label>住所</label>
                        <input type="text" class="input" name="address" placeholder="例：○○-○○丁目-○○番-○○○" value="<?= $address ?>">

                    </li>

                    <li><label>電話番号</label>
                        <input class="input" type="tel" name="tel"placeholder="-なし10～11桁の半角数字" value="<?= $tel ?>">
                    </li>


                    <li><label>メール</label>
                        <input class="input" type="email" name="email"placeholder="例：aaa@a.com" value="<?= $email ?>">

                    </li>

                    <li><label>メール確認</label>
                        <input class="input" type="email" name="emailConfirm" placeholder="もう一度入力">

                    </li>

                    <li>
                        <label>ID</label>
                        <input type="text" class="input" name="staff_id" maxlength="10" placeholder="半角英数字" value="<?= $staff_id ?>">
                    </li>

                    <li><label>パスワード</label>
                        <input class="input" type="password" name="password" placeholder="英数字混ぜて8位以上">

                    </li>

                    <li><label>パスワード確認</label>
                        <input class="input" type="password" name="passwordConfirm" placeholder="もう一度入力">

                    </li>
                </ul>
            </div>

            <div class="center">
                <input type="submit" class="button" name="confirm" value="確認">
                <a href="<?php echo $href . "systemuser_list.php" ?>">
                    <input type="button" class="button" title="return" value="戻る">
                </a><br>
        </form>
        </div>

    <?php endif; ?>



    <?php if ($pageFlag === 1) : ?>
        <!-- 確認画面 -->

        <div class="center">
            <h2>ユーザー情報確認</h2>


            <form method="POST" action="">
                <div class="page">
                    <?php

                    //変数定義
                    $staff_id = $_POST['staff_id'];
                    $last_name = $_POST['last_name'];
                    $first_name = $_POST['first_name'];
                    $staff_gender = $_POST['gender'];
                    $B_year = $_POST['B_year'];
                    $B_month = $_POST['B_month'];
                    $B_date = $_POST['B_date'];
                    $birthday = $B_year . sprintf("%02d", $B_month) . sprintf("%02d", $B_date);
                    $age = $_POST['age'];
                    $year = $_POST['year'];
                    $month = $_POST['month'];
                    $date = $_POST['date'];
                    $date_company = $B_year . sprintf("%02d", $month) . sprintf("%02d", $date);
                    $syozoku_store_id = $_POST['syozoku_store_id'];
                    $type_employment = $_POST['type_employment'];
                    $role = $_POST['role'];
                    $teacher = $_POST['teacher'];
                    $zipcode1 = $_POST['zipcode1'];
                    $zipcode2 = $_POST['zipcode2'];
                    $prefectures = $_POST['prefectures'];
                    $ward = $_POST['ward'];
                    $address = $_POST['address'];
                    $tel = $_POST['tel'];
                    $email = $_POST['email'];
                    $emailConfirm = $_POST['emailConfirm'];
                    $password = $_POST['password'];
                    $passwordConfirm = $_POST['passwordConfirm'];





                    echo '<br>ID:';
                    echo $staff_id;
                    echo '<hr>';

                    echo 'お名前:';
                    echo  $last_name . " " . $first_name;
                    echo '<hr>';

                    echo '性別:';
                    if ($staff_gender == 1) {
                        echo '男性';
                    } elseif ($staff_gender == 2) {
                        echo '女性';
                    } elseif ($staff_gender == 9) {
                        echo 'その他';
                    }
                    echo '<hr>';

                    echo '生年月日:';
                    echo  $B_year, "年", sprintf("%02d", $B_month), "月", sprintf("%02d", $B_date), "日";
                    echo '<hr>';

                    echo '年齢:';
                    echo $age . "歳";
                    echo '<hr>';

                    echo '入社日:';
                    echo  $year, "年", sprintf("%02d", $month), "月", sprintf("%02d", $date), "日";
                    echo '<hr>';

                    echo '所属店舗ID:';
                    echo $syozoku_store_id;
                    echo '<hr>';

                    echo '雇用形態:';
                    if ($type_employment == 1) {
                        echo '社員';
                    } elseif ($type_employment == 2) {
                        echo 'パート';
                    } elseif ($type_employment == 9) {
                        echo 'その他';
                    }
                    echo '<hr>';

                    echo '役割:';
                    if ($role == 1) {
                        echo '管理者';
                    } elseif ($role == 2) {
                        echo '講師';
                    } elseif ($role == 3) {
                        echo '受付';
                    } elseif ($role == 9) {
                        echo 'その他';
                    }
                    echo '<hr>';

                    echo '講師:';
                    if ($teacher == 1) {
                        echo '講師可';
                    } else {
                        echo '講師不可';
                    }
                    echo '<hr>';

                    echo '郵便番号:';
                    echo $zipcode1 . "-" . $zipcode2;
                    echo '<hr>';

                    echo "都道府県:";
                    echo $prefectures;
                    echo '<hr>';

                    echo "区市町村:";
                    echo $ward;
                    echo '<hr>';

                    echo "住所:";
                    echo $address;
                    echo '<hr>';

                    echo "電話番号:";
                    echo $tel;
                    echo '<hr>';

                    echo 'メールアドレス:';
                    echo $email;
                    echo '<hr>';

                    echo 'パスワード:';
                    echo $password;
                    echo '<br><br>';


                    echo '<input type="hidden" name="staff_id" value="' . $staff_id . '">';
                    echo '<input type="hidden" name="last_name" value="' . $last_name . '">';
                    echo '<input type="hidden" name="first_name" value="' . $first_name . '">';
                    echo '<input type="hidden" name="gender" value="' . $staff_gender . '">';
                    echo '<input type="hidden" name="birthday" value="' . $birthday . '">';
                    echo '<input type="hidden" name="age" value="' . $age . '">';
                    echo '<input type="hidden" name="date_company" value="' . $date_company . '">';
                    echo '<input type="hidden" name="syozoku_store_id" value="' . $syozoku_store_id . '">';
                    echo '<input type="hidden" name="type_employment" value="' . $type_employment . '">';
                    echo '<input type="hidden" name="role" value="' . $role . '">';
                    echo '<input type="hidden" name="teacher" value="' . $teacher . '">';
                    echo '<input type="hidden" name="zipcode1" value="' . $zipcode1 . '">';
                    echo '<input type="hidden" name="zipcode2" value="' . $zipcode2 . '">';
                    echo '<input type="hidden" name="prefectures" value="' . $prefectures . '">';
                    echo '<input type="hidden" name="ward" value="' . $ward . '">';
                    echo '<input type="hidden" name="address" value="' . $address . '">';
                    echo '<input type="hidden" name="tel" value="' . $tel . '">';
                    echo '<input type="hidden" name="email" value="' . $email . '">';
                    echo '<input type="hidden" name="password" value="' . $password . '">';


                    ?>
                </div>

                <input class="button" type="submit" name="register" value="登録" onclick='return confirm("登録しますか？");'>
                <input class="button" type="button" onclick="history.back()" value="戻る">

            </form>
        </div>

    <?php endif; ?>


    <?php if ($pageFlag === 2) : ?>
        <!-- 完了画面 -->

        <?php

                try {
                    $pdo = GetDb();

                    //DB内のstaff_idを取得
                    $staff_id = $_POST['staff_id'];
                    $sql = "select staff_id from m_systemuser where staff_id = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$staff_id]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    //------------------------
                    //INSERT（prepare→execute）
                    //------------------------

                    //DB内のstaff_idと重複していない場合、登録する。
                    if (!isset($row['staff_id'])) {

                        $sql = "INSERT INTO m_systemuser(staff_id,last_name,first_name,gender,birthday,age,date_company,syozoku_store_id,type_employment,role,teacher,zipcode1,zipcode2,prefectures,ward,address,tel,email,password,create_date) VALUES(:staff_id,:last_name,:first_name,:gender,:birthday,:age,:date_company,:syozoku_store_id,:type_employment,:role,:teacher,:zipcode1,:zipcode2,:prefectures,:ward,:address,:tel,:email,:password,:create_date);";
                        $stmt = $pdo->prepare($sql);

                        //bindParamを利用したSQL文の実行
                        $stmt->bindParam(':staff_id', $staff_id);
                        $stmt->bindParam(':last_name', $last_name);
                        $stmt->bindParam(':first_name', $first_name);
                        $stmt->bindParam(':gender', $gender);
                        $stmt->bindParam(':birthday', $birthday);
                        $stmt->bindParam(':age', $age);
                        $stmt->bindParam(':date_company', $date_company);
                        $stmt->bindParam(':syozoku_store_id', $syozoku_store_id);
                        $stmt->bindParam(':type_employment', $type_employment);
                        $stmt->bindParam(':role', $role);
                        $stmt->bindParam(':teacher', $teacher);
                        $stmt->bindParam(':zipcode1', $zipcode1);
                        $stmt->bindParam(':zipcode2', $zipcode2);
                        $stmt->bindParam(':prefectures', $prefectures);
                        $stmt->bindParam(':ward', $ward);
                        $stmt->bindParam(':address', $address);
                        $stmt->bindParam(':tel', $tel);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':password', $hash_pass);
                        $stmt->bindParam(':create_date', $create_date);

                        // set parameters and execute

                        $last_name = $_POST['last_name'];
                        $first_name = $_POST['first_name'];
                        $staff_gender = $_POST['gender'];
                        $gender = $_POST['gender'];
                        $birthday = $_POST['birthday'];
                        $age = $_POST['age'];
                        $date_company = $_POST['date_company'];
                        $syozoku_store_id = $_POST['syozoku_store_id'];
                        $type_employment = $_POST['type_employment'];
                        $role = $_POST['role'];
                        $teacher = $_POST['teacher'];
                        $zipcode1 = $_POST['zipcode1'];
                        $zipcode2 = $_POST['zipcode2'];
                        $prefectures = $_POST['prefectures'];
                        $ward = $_POST['ward'];
                        $address = $_POST['address'];
                        $tel = $_POST['tel'];
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                        $hash_pass = password_hash($password, PASSWORD_DEFAULT); //パスワードの暗号化
                        $create_date  = date("Y/m/d H:i:s");
                        $stmt->execute();
                        header('location:systemuser_list.php');
                    } else {

                        $msg = "ID既に存在しました<br>";
                        $link = '<input type="button" onclick="history.back()" value="戻る">';

                        if (!($stmt->execute())) {
                            $err = $pdo->errorInfo();
                            $msg = 'データ追加できませんでした' . $err[2];
                            $link = '<br><a href="' . $href . 'staff_register.php"><input type="button" value="戻る"></a>';
                        }
                    }
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗:' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;

                echo $msg;
                echo $link;

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