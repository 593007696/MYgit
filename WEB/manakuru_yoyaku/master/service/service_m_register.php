<!DOCTYPE html>
<html>
<?php date_default_timezone_set('asia/tokyo'); ?>
<!-- タイムゾーンの設定をSessionManagerに追加してな-->

<head>
    <meta charset="UTF8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>サービスマスター新規登録</title>
    <script type="text/javascript">
        window.onload = function() {
            document.getElementById('title').focus();
        }
    </script>


    <script>
        function getid(store_id) {

            var idx = store_id.selectedIndex;
            var value = store_id.options[idx].value;

            document.getElementById("store_id").textcontent = value;

        }
    </script>

    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">

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
            /*************************************************************************************************
        データベースの接続(PDO) && バリデーションファイル && XSS対策 && clickjacking対策
             *************************************************************************************************/
            //データベース接続
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

            //バリデーションファイルをimport
            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/ValidationManager_mservice.php');

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

            if (!empty($_POST['confirm']) && empty($error)) {
                $pageFlag = 1;
            }

            if (!empty($_POST['register'])) {
                $pageFlag = 2;
            }
?>

<?php if (!empty($_POST['confirm']) && !empty($error)) : ?>
    <ul class="error">
        <?php foreach ($error as $value) : ?>
            <li><?= $value; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>



<?php

            try {
                $pdo = GetDb();

                //店舗セレクトボックス
                $sql = "SELECT * FROM m_store";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                //レコード件数
                $row_count = $stmt->rowCount();

                //連想配列で取得
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $rows[] = $row;
                }
            } catch (PDOException $e) {
                echo 'データベースに接続失敗：' . $e->getMessage();
            }

            // 接続を閉じる
            $pdo = null;

?>


<?php if ($pageFlag === 0) : ?>
    <!-- 入力画面 -->

    <body>
        <div class="center">
            <div class="sheet">
                <h2>サービスマスター新規登録</h2>

                <ul class="service">
                    <form action="" method="post">

                        <label id="label">店舗: </label>

                        <li class="service">
                            <select id="store_id" class="input" name="store_id" onchange='getid(this);'>";
                                <?php
                                if ($row_count != 0) {
                                    foreach ($rows as $row) {
                                        $store_name = $row['store_name'];
                                        $store_id   = $row['store_id'];

                                        if ($store_name == h($_SESSION['STORE_NAME'])) {
                                            echo " <option value=\"" . $store_id . "\" selected>" . $store_name . "</option>\n";
                                        } else {
                                            echo " <option value=\"" . $store_id . "\">" . $store_name . "</option>\n";
                                        }
                                    }
                                }

                                ?>
                            </select>
                        </li>

                        <br>
                        <br>

                        <label id="label">サービス名:</label>

                        <li class="service">
                            <select name="service_name" id="service" class="input">
                                <option value="">--</option>
                                <option value="就職ガイドコース" <?php if (!empty($_POST['service_name']) && $_POST['service_name'] === "就職ガイドコース") {
                                                                echo 'selected';
                                                            } ?> id="1">就職ガイドコース</option>
                                <option value="まなクルプログラムコース" <?php if (!empty($_POST['service_name']) && $_POST['service_name'] === "まなクルプログラムコース") {
                                                                    echo 'selected';
                                                                } ?> id="2">まなクルプログラムコース</option>
                                <option value="まなクルExcelコース" <?php if (!empty($_POST['service_name']) && $_POST['service_name'] === "まなクルExcelコース") {
                                                                    echo 'selected';
                                                                } ?> id="3">まなクルExcelコース</option>
                                <option value="まなクルWordコース" <?php if (!empty($_POST['service_name']) && $_POST['service_name'] === "まなクルWordコース") {
                                                                echo 'selected';
                                                            } ?> id="4">まなクルWordコース</option>
                                <option value="まなクルキッズ英会話コース" <?php if (!empty($_POST['service_name']) && $_POST['service_name'] === "まなクルキッズ英会話コース") {
                                                                    echo 'selected';
                                                                } ?> id="5">まなクルキッズ英会話コース</option>
                                <option value="まなクルキッズ音楽コース" <?php if (!empty($_POST['service_name']) && $_POST['service_name'] === "まなクルキッズ音楽コース") {
                                                                    echo 'selected';
                                                                } ?> id="6">まなクルキッズ音楽コース</option>
                                <option value="まなクルEnglishコース" <?php if (!empty($_POST['service_name']) && $_POST['service_name'] === "まなクルEnglishコース") {
                                                                    echo 'selected';
                                                                } ?> id="7">まなクルEnglishコース</option>
                                <option value="まなクル特別コース" <?php if (!empty($_POST['service_name']) && $_POST['service_name'] === "まなクル特別コース") {
                                                                echo 'selected';
                                                            } ?> id="8">まなクル特別コース</option>
                                <option value="その他サービス" <?php if (!empty($_POST['service_name']) && $_POST['service_name'] === "その他サービス") {
                                                            echo 'selected';
                                                        } ?> id="90">その他</option>
                            </select>
                        </li>
                        <br>
                        <br>


                        <label id="label">タイトル:</label>
                        <li class="service">
                            <input type="text" class="input" name="service_title" size="40" placeholder="(講座名/職種)" maxlength="30" value="<?php if (!empty($clean['service_title'])) {
                                                                                                                                                echo $clean['service_title'];
                                                                                                                                            } ?>">
                        </li>
                        <br>
                        <br>


                        <label id="label">サービス単位:</label>
                        <li class="service">
                            <label for="service_flg" class="btn-radio">
                                <input type="radio" name="service_flg" value="0" <?php if ((filter_input(INPUT_POST, "service_flg") != null) && $clean['service_flg'] === "0") {
                                                                                        echo 'checked';
                                                                                    } ?> id="service_flg" 　>

                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="9"></circle>
                                    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                                </svg>
                                サービス
                            </label>

                            <label for="time_flg" class="btn-radio">
                                <input type="radio" name="service_flg" value="1" <?php if (!empty($clean['service_flg']) && $clean['service_flg'] === "1") {
                                                                                        echo 'checked';
                                                                                    } ?> id="time_flg" 　>

                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="9"></circle>
                                    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                                </svg>
                                時間
                            </label>
                        </li>

                        <br>
                        <br>


                        <label id="label">コマ数:</label>
                        <li class="service">
                            <input type="text" class="input" name="frequency" maxlength="15" value="<?php if (!empty($clean['frequency'])) {
                                                                                                        echo $clean['frequency'];
                                                                                                    } ?>">
                        </li>
                        <br>
                        <br>


                        <label id="label">月数:</label>
                        <li class="service">
                            <select name="month" size="1" id="month" class="input">
                                <option value="">--</option>
                                <option value="1ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "1ヶ月") {
                                                        echo 'selected';
                                                    } ?>>1ヶ月</option>
                                <option value="2ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "2ヶ月") {
                                                        echo 'selected';
                                                    } ?>>2ヶ月</option>
                                <option value="3ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "3ヶ月") {
                                                        echo 'selected';
                                                    } ?>>3ヶ月</option>
                                <option value="4ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "4ヶ月") {
                                                        echo 'selected';
                                                    } ?>>4ヶ月</option>
                                <option value="5ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "5ヶ月") {
                                                        echo 'selected';
                                                    } ?>>5ヶ月</option>
                                <option value="6ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "6ヶ月") {
                                                        echo 'selected';
                                                    } ?>>6ヶ月</option>
                                <option value="7ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "7ヶ月") {
                                                        echo 'selected';
                                                    } ?>>7ヶ月</option>
                                <option value="8ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "8ヶ月") {
                                                        echo 'selected';
                                                    } ?>>8ヶ月</option>
                                <option value="9ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "9ヶ月") {
                                                        echo 'selected';
                                                    } ?>>9ヶ月</option>
                                <option value="10ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "10ヶ月") {
                                                            echo 'selected';
                                                        } ?>>10ヶ月</option>
                                <option value="11ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "11ヶ月") {
                                                            echo 'selected';
                                                        } ?>>11ヶ月</option>
                                <option value="12ヶ月" <?php if (!empty($_POST['month']) && $_POST['month'] === "12ヶ月") {
                                                            echo 'selected';
                                                        } ?>>12ヶ月</option>
                                <option value="期限なし" <?php if (!empty($_POST['month']) && $_POST['month'] === "期限なし") {
                                                            echo 'selected';
                                                        } ?>>期限なし</option>
                            </select>
                        </li>
                        <br>
                        <br>


                        <label id="label">対象者:</label>
                        <li class="service">
                            <input type="text" class="input" name="target" size="40" maxlength="20" 　id="tget" value="<?php if (!empty($clean['target'])) {
                                                                                                                            echo $clean['target'];
                                                                                                                        } ?>">
                        </li>
                        <br>
                        <br>


                        <label id="label">最大予約者数:</label>
                        <li class="service">
                            <input type="text" class="input" name="max_cnt" size="40" maxlength="20" 　id="cnt" value="<?php if (!empty($clean['max_cnt'])) {
                                                                                                                            echo $clean['max_cnt'];
                                                                                                                        } ?>">

                        </li>
                        <br>
                        <br>


                        <label id="label"> 概要:</label>
                        <li class="service">
                            <textarea name="overview" class="input" maxlength="200" id="view" value="<?php if (!empty($clean['overview'])) {
                                                                                                            echo $clean['overview'];
                                                                                                        } ?>"></textarea>
                        </li>
                        <br>
                        <br>


                        <label id="label">料金(円):</label>
                        <li class="service">
                            <input type="text" class="input" data-type="number" name="price" maxlength="8" value="<?php if (!empty($clean['price'])) {
                                                                                                                        echo $clean['price'];
                                                                                                                    } ?>">
                        </li>
                        <br>
                        <br>


                        <label id="label">開始状態:</label>
                        <li class="service">
                            <label for="open" class="btn-radio">
                                <input type="radio" name="open_flg" value="1" <?php if (!empty($clean['open_flg']) && $clean['open_flg'] === "1") {
                                                                                    echo 'checked';
                                                                                } ?> id="open">

                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="9"></circle>
                                    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                                </svg>
                                開始中
                            </label>

                            <label for="close" class="btn-radio">
                                <input type="radio" name="open_flg" value="0" <?php if ((filter_input(INPUT_POST, "open_flg") != null) && $clean['open_flg'] === "0") {
                                                                                    echo 'checked';
                                                                                } ?> id="close">

                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="9"></circle>
                                    <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                                    <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                                </svg>
                                停止中
                            </label>
                        </li>
                </ul>
                <br>
                <br>

                <input type="submit" class="button" name="confirm" value="登録">
                <a href="service_m_list.php"><input type="button" class="button" title="return" value="戻る">
                    </form>
            </div>
        </div>

    </body>

</html>
<?php endif; ?>


<?php if ($pageFlag === 1) : ?>
    <div class="center">
        <!-- 確認画面 -->
        <h2>サービスマスター新規登録確認</h2>

        <?php

                $store_id = $_POST['store_id'];

                try {

                    $pdo = GetDb();

                    //店舗名取得
                    $sql = "SELECT * FROM m_store WHERE store_id = $store_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindcolumn('store_name', $store_name);
                    $stmt->execute();

                    $stmt->fetch(PDO::FETCH_BOUND);
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗：' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;



        ?>

        <form method="POST" action="">
            <div class="page">
                <?php
                //変数定義
                $store_id = html($_POST['store_id']);
                $store_name = html($store_name);
                $service_name = html($_POST['service_name']);
                $service_title = html($_POST['service_title']);
                $service_flg = html($_POST['service_flg']);
                $frequency = html($_POST['frequency']);
                $month = html($_POST['month']);
                $target = html($_POST['target']);
                $max_cnt = html($_POST['max_cnt']);
                $overview = html($_POST['overview']);
                $price = html($_POST['price']);
                $open_flg = html($_POST['open_flg']);

                echo '<br>';
                echo '店舗:  ';
                echo  $store_name;
                echo '<hr><br>';

                echo 'サービス名:  ';
                echo $service_name;
                echo '<hr><br>';

                echo 'タイトル(講座名/職種):  ';
                echo $service_title;
                echo '<hr><br>';

                echo 'サービス単位:  ';
                if ($service_flg == 0) {
                    echo 'サービス単位';
                } elseif ($service_flg == 1) {
                    echo '時間単位';
                };
                echo '<hr><br>';

                echo 'コマ数:  ';
                echo $frequency;
                echo '<hr><br>';

                echo '月数:  ';
                echo $month;
                echo '<hr><br>';

                echo '対象者:  ';
                echo $target;
                echo '<hr><br>';

                echo '最大予約者数:  ';
                echo $max_cnt;
                echo '<hr><br>';

                echo '概要:  ';
                echo $overview;
                echo '<hr><br>';

                echo '料金(円):  ';
                echo $price;
                echo '<hr><br>';

                echo '開始状態:';
                if ($open_flg == 1) {
                    echo '開始中';
                } elseif ($open_flg == 0) {
                    echo '停止中';
                };

                //予約フラグの設定

                if ($open_flg == 1) {

                    $yoyaku_flg = $open_flg;    //予約可

                } elseif ($open_flg == 0) {

                    $yoyaku_flg = $open_flg;    //予約不可

                }



                echo '<input type="hidden" name="store_id" value="' . $store_id . '">';
                echo '<input type="hidden" name="service_name" value="' . $service_name . '">';
                echo '<input type="hidden" name="service_title" value="' . $service_title . '">';
                echo '<input type="hidden" name="service_flg" value="' . $service_flg . '">';
                echo '<input type="hidden" name="frequency" value="' . $frequency . '">';
                echo '<input type="hidden" name="month" value="' . $month . '">';
                echo '<input type="hidden" name="target" value="' . $target . '">';
                echo '<input type="hidden" name="max_cnt" value="' . $max_cnt . '">';
                echo '<input type="hidden" name="overview" value="' . $overview . '">';
                echo '<input type="hidden" name="price" value="' . $price . '">';
                echo '<input type="hidden" name="open_flg" value="' . $open_flg . '">';
                echo '<input type="hidden" name="yoyaku_flg" value="' . $yoyaku_flg . '">';

                ?>
            </div>

            <input class="button" type="submit" name="register" value="確定" onclick="return confirm('登録してもよろしいですか？');">
            <input class="button" type="button" onclick="history.back()" value="戻る">
        </form>
    </div>
<?php endif; ?>


<?php if ($pageFlag === 2) : ?>
    <!-- 完了画面 -->

    <?php
                try {

                    $pdo = GetDb();
                    $store_id = $_POST['store_id'];
                    $service_name = $_POST['service_name'];
                    $service_title = $_POST['service_title'];
                    $service_flg = $_POST['service_flg'];
                    $frequency = $_POST['frequency'];
                    $month = $_POST['month'];
                    $target = $_POST['target'];
                    $max_cnt = $_POST['max_cnt'];
                    $overview = $_POST['overview'];
                    $price = $_POST['price'];
                    $open_flg = $_POST['open_flg'];
                    $yoyaku_flg = $_POST['yoyaku_flg'];
                    $created_date = date("Y/m/d H:i:s");



                    $sql =
                        "SELECT max(service_id) 
                FROM m_service
                WHERE store_id = :store_id
                ";
                    $maxid = $pdo->prepare($sql);
                    $maxid->bindParam(':store_id', $store_id);      //service_id設定
                    $maxid->execute();

                    $get_max_id = $maxid->fetch(PDO::FETCH_NUM);
                    $service_id = $get_max_id[0] + 1;



                    $sql = "INSERT INTO m_service(store_id,
                service_id,
                service_name,
                service_title,
                service_flg,
                frequency,
                month,
                target,
                max_cnt,
                overview,
                price,
                open_flg,
                yoyaku_flg,
                created_date) 

                VALUES(:store_id,
                :service_id,
                :service_name,
                :service_title,
                :service_flg,
                :frequency,
                :month,
                :target,
                :max_cnt,
                :overview,
                :price,
                :open_flg,
                :yoyaku_flg,
                :created_date);";

                    $stmt = $pdo->prepare($sql);
                    $array = array(
                        ':store_id' => $store_id,
                        ':service_id' => $service_id,
                        ':service_name' => $service_name,
                        ':service_title' => $service_title,
                        ':service_flg' => $service_flg,
                        ':frequency' => $frequency,
                        ':month' => $month,
                        ':target' => $target,
                        ':max_cnt' => $max_cnt,
                        ':overview' => $overview,
                        ':price' => $price,
                        ':open_flg' => $open_flg,
                        ':yoyaku_flg' => $yoyaku_flg,
                        ':created_date' => $created_date
                    );
                    $stmt->execute($array);

                    header('location:service_m_list.php');
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

<br><br>
<footer> ©2020 株式会社ジェイテック</footer>