<!DOCTYPE html>
<html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>

    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/form.css" type="text/css">
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
    <meta charset="utf-8" />
    <title>ユーザーマスター更新</title>
    <!--郵便番号-->
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <script src="../js/ajaxzip3.js" charset="UTF-8"></script>
</head>

<body>

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
                include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/ValidationManager_systermuser_cfm.php');

                //clickjacking対策
                header('X-FRAME-OPTIONS: DENY');


                $pageFlag = 0;
                $error = validation($_POST);

                if (!empty($_POST['update']) && empty($error)) {
                    $pageFlag = 1;
                }
    ?>


    <!-- 確認ボタンが空ではなく、且つエラーが空ではなかったら -->
    <?php if (!empty($_POST['update']) && !empty($error)) : ?>
        <ul class="error">
            <!-- $errorは連想配列なのでforeachで分解していく -->
            <?php foreach ($error as $value) : ?>
                <!-- 分解したエラー文をlistの中に表示していく -->
                <li><?php echo $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>



    <?php if ($pageFlag === 0) : ?>


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


        <!--DBから情報のセレクト-->
        <?php

                    //DBから誕生日をプルダウンメニューに
                    function GetBirthday($init, $now, $cnt)
                    {

                        for ($i = $init; $i <= $now; $i++) {
                            if ($i == intval(trim($cnt))) {
                                echo " <option value='" . $i . "' selected>" . $i . "</option>";
                            } else {
                                echo " <option value='" . $i . "'>" . $i . "</option>";
                            }
                        }

                        return $init;
                        return $now;
                        return $cnt;
                    }

                    //DBから入社日をプルダウンメニューに
                    function GetDC($init, $now, $cnt)
                    {

                        for ($j = $init; $j <= $now; $j++) {
                            if ($j == intval(trim($cnt))) {
                                echo " <option value='" . $j . "' selected>" . $j . "</option>";
                            } else {
                                echo " <option value='" . $j . "'>" . $j . "</option>";
                            }
                        }

                        return $init;
                        return $now;
                        return $cnt;
                    }


                    try {
                        $pdo = GetDb();

                        // set parameters and execute
                        $stmt = $pdo->prepare('SELECT * FROM m_systemuser WHERE staff_id = :staff_id');
                        $stmt->execute(array(':staff_id' => $_POST["staff_id"]));
                        $result = 0;
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        echo 'データベースに接続失敗:' . $e->getMessage();
                    }

                    // 接続を閉じる
                    $pdo = null;

        ?>


        <!--更新フォーム-->
        <div class="center">
            <h2>ユーザー更新</h2>
            <span>ID:</span>
            <?php echo $result['staff_id']; ?>
        </div>



        <form method="post" action="">
            <input type="hidden" name="staff_id" value="<?php echo $result['staff_id']; ?>">

            <div class="form">
                <ul>

                    <li>
                        <label>姓:</label>
                        <input type="text" class="input" name="last_name" value="<?php echo $result['last_name']; ?>">
                    </li>

                    <li>
                        <label>名:</label>
                        <input type="text" class="input" name="first_name" value="<?php echo $result['first_name']; ?>">
                    </li>

                    <li>
                        <label>性別:</label>


                        <label for="male" class="btn-radio">

                            <input type="radio" name="gender" value="1" <?php if ($result['gender'] == 1) {
                                                                            echo "checked";
                                                                        } ?> id="male">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>男</span>
                        </label>


                        <label for="female" class="btn-radio">

                            <input type="radio" name="gender" value="2" <?php if ($result['gender'] == 2) {
                                                                            echo "checked";
                                                                        } ?> id="female">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>女</span>
                        </label>


                        <label for="other" class="btn-radio">

                            <input type="radio" name="gender" value="9" <?php if ($result['gender'] == 9) {
                                                                            echo "checked";
                                                                        } ?> id="other">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>その他</span>
                        </label>
                    </li>


                    <li>
                        <label>生年月日:</label>
                        <?php

                        $birthday = date('Y-m-d', strtotime($result['birthday']));

                        // ハイフン区切りで取り出す
                        list($B_year, $B_month, $B_day) = explode('-', $birthday);

                        echo '<select name="B_year">';

                        $now = date("Y");
                        GetBirthday(1900, $now, $B_year);

                        echo '</select>';

                        echo '<select name="B_month">';

                        $now = 12;
                        GetBirthday(1, $now, $B_month);

                        echo '</select>';

                        echo '<select name="B_date">';

                        $now = 31;
                        GetBirthday(1, $now, $B_date);

                        echo '</select>';

                        ?>
                    </li>

                    <!--
                    <li>
                    <span>年齢:</span>
                    <?php
                    $currentdate = date('Y/m/d');
                    $c = (int)date('Ymd', strtotime($currentdate));
                    $b = (int)date('Ymd', strtotime($birthday));
                    $age = (int)(($c - $b) / 10000);

                    echo $age . '歳';
                    ?>
                    -->

                    <li>
                        <label>入社日:</label>
                        <?php

                        $date_company = date('Y-m-d', strtotime($result['date_company']));

                        // ハイフン区切りで取り出す
                        list($year, $month, $date) = explode('-', $date_company);

                        echo '<select name="year">';

                        $now = date("Y");
                        GetDC(1900, $now, $year);

                        echo '</select>';

                        echo '<select name="month">';

                        $now = 12;
                        GetDC(1, $now, $month);

                        echo '</select>';

                        echo '<select name="date">';

                        $now = 31;
                        GetDC(1, $now, $date);

                        echo '</select>';

                        ?>

                    <li>
                        <label>所属店舗:</label>

                        <select id="store" name="syozoku_store_id">";
                            <option value='0'>--</option>
                            <?php
                            if ($row_count != 0) {
                                foreach ($rows as $row) {
                                    $store_name = $row['store_name'];
                                    $store_id   = $row['store_id'];
                                    if (!empty($result['syozoku_store_id']) && $result['syozoku_store_id'] == $store_id) {
                                        echo " <option value='" . $store_id . "' selected>" . $store_name . "</option>";
                                    } else {
                                        echo " <option value='" . $store_id . "'>" . $store_name . "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </li>

                    <li>
                        <label>雇用形態:</label>

                        <label for="full_time" class="btn-radio">

                            <input type="radio" name="type_employment" value="1" <?php if ($result['type_employment'] == 1)  echo "checked" ?> id="full_time">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>正社員</span>
                        </label>


                        <label for="part_time" class="btn-radio">

                            <input type="radio" name="type_employment" value="2" <?php if ($result['type_employment'] == 2)  echo "checked" ?> id="part_time">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>アルバイト</span>
                        </label>


                        <label for="type_other" class="btn-radio">

                            <input type="radio" name="type_employment" value="9" <?php if ($result['type_employment'] == 9)  echo "checked" ?> id="type_other">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>その他</span>
                        </label>
                    </li>



                    <li>
                        <label>役割:</label>

                        <label for="admin" class="btn-radio">

                            <input type="radio" name="role" value="1" <?php if ($result['role'] == 1)  echo "checked" ?> id="admin">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>管理者</span>
                        </label>


                        <label for="teacher" class="btn-radio">

                            <input type="radio" name="role" value="2" <?php if ($result['role'] == 2)  echo "checked" ?> id="teacher"">
              
                            <svg width=" 20px" height="20px" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="9"></circle>
                            <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                            <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>講師</span>
                        </label>


                        <label for="reception" class="btn-radio">

                            <input type="radio" name="role" value="3" <?php if ($result['role'] == 3)  echo "checked" ?> id="reception">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>受付</span>
                        </label>


                        <label for="role_other" class="btn-radio">

                            <input type="radio" name="role" value="9" <?php if ($result['role'] == 9)  echo "checked" ?> id="role_other">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>その他</span>
                        </label>
                    </li>

                    <li>
                        <label>講師可否:</label>

                        <label for="teacher_y" class="btn-radio">

                            <input type="radio" name="teacher" value="1" <?php if ($result['teacher'] == 1)  echo "checked" ?> id="teacher_y">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>講師可</span>
                        </label>


                        <label for="teacher_n" class="btn-radio">

                            <input type="radio" name="teacher" value="0" <?php if ($result['teacher'] == 2)  echo "checked" ?> id="teacher_n">

                            <svg width="20px" height="20px" viewBox="0 0 20 20">
                                <circle cx="10" cy="10" r="9"></circle>
                                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                            </svg>
                            <span>講師不可</span>
                        </label>
                    </li>


                    <li>
                        <label>郵便番号:</label>
                        <input style="width: 50px;" type="text" class="input" name="zipcode1" value="<?php echo $result['zipcode1']; ?>">
                        <a>－</a>
                        <input style="width: 85px;" type="text" class="input" name="zipcode2" value="<?php echo $result['zipcode2']; ?>" onKeyUp="AjaxZip3.zip2addr('zipcode1','zipcode2','prefectures','ward','address');">
                    </li>

                    <li>
                        <label>都道府県:</label>
                        <input type="text" class="input" name="prefectures" value="<?php echo $result['prefectures']; ?>">
                    </li>

                    <li>
                        <label>区市町村:</label>
                        <input type="text" class="input" name="ward" value="<?php echo $result['ward']; ?>">
                    </li>

                    <li>
                        <label>住所:</label>
                        <input type="text" class="input" name="address" value="<?php echo $result['address']; ?>">
                    </li>

                    <li>
                        <label>電話番号:</label>
                        <input type="text" class="input" name="tel" value="<?php echo $result['tel']; ?>">
                    </li>

                    <li>
                        <label>メール:</label>
                        <input type="text" class="input" name="email" value="<?php echo $result['email']; ?>">
                    </li>


                </ul>
            </div>

            <div class="center">
                <input class="button" type="submit" name="update" value="更新" onclick='return confirm("更新しますか？");'>
                <a href="<?php echo $href . "systemuser_list.php" ?>">
                    <input type="button" class="button" title="return" value="戻る">
                </a>
            </div>

        </form>




    <?php endif; ?>


    <?php if ($pageFlag === 1) : ?>

<?php

                    //timezon設定
                    date_default_timezone_set('Asia/Tokyo');
                    $update_date  = date("Y/m/d H:i:s");
                    $B_year = $_POST['B_year'];
                    $B_month = sprintf('%02d', $_POST['B_month']);
                    $B_date = sprintf('%02d', $_POST['B_date']);
                    $birthday = $B_year . $B_month . $B_date;

                    $currentdate = date('Y/m/d');
                    $c = (int)date('Ymd', strtotime($currentdate));
                    $b = (int)date('Ymd', strtotime($birthday));
                    $age = (int)(($c - $b) / 10000);


                    $year = $_POST['year'];
                    $month = sprintf('%02d', $_POST['month']);
                    $date = sprintf('%02d', $_POST['date']);
                    $date_company = $year . $month . $date;

                    $staff_id = $_POST['staff_id'];
                    $last_name = $_POST['last_name'];
                    $first_name = $_POST['first_name'];
                    $gender = $_POST['gender'];
                    $syozoku_store_id = $_POST['syozoku_store_id'];
                    $type_employment = $_POST['type_employment'];
                    $role = $_POST['role'];
                    $teacher = $_POST['teacher'];
                    $zipcode1 = $_POST['zipcode1'];
                    $zipcode2 = $_POST['zipcode2'];
                    $prefectures = $_POST['prefectures'];
                    $ward = $_POST['ward'];
                    $adrress = $_POST['address'];
                    $tel = $_POST['tel'];
                    $email = $_POST['email'];

                    try {
                        $pdo = GetDb();

                        $sql = 'UPDATE m_systemuser SET last_name = :last_name,first_name = :first_name,gender =:gender,birthday =:birthday,age=:age,date_company=:date_company,syozoku_store_id=:syozoku_store_id, type_employment=:type_employment,role=:role,teacher=:teacher,zipcode1 =:zipcode1,zipcode2=:zipcode2,prefectures=:prefectures,ward=:ward,address=:address,tel=:tel,email=:email,update_date=:update_date WHERE staff_id = :staff_id';
                        $stmt = $pdo->prepare($sql);
                        $array = array(':last_name' => $last_name, ':first_name' => $first_name, ':gender' => $gender, ':birthday' => $birthday, ':age' => $age, ':date_company' => $date_company, ':syozoku_store_id' => $syozoku_store_id, ':type_employment' => $type_employment, ':role' => $role, ':teacher' => $teacher, ':zipcode1' => $zipcode1, ':zipcode2' => $zipcode2, ':prefectures' => $prefectures, ':ward' => $ward, ':address' => $adrress, ':tel' => $tel, ':email' => $email, ':update_date' => $update_date, ':staff_id' => $staff_id);
                        $stmt->execute($array);

                        header('location:systemuser_list.php');
                    } catch (PDOException $e) {
                        echo 'データベースに接続失敗:' . $e->getMessage();
                    }

                    // 接続を閉じる
                    $pdo = null;

                endif;
            }
        }
?>
</body>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>


</html>