<!DOCTYPE html>
<html>
<?php date_default_timezone_set('asia/tokyo'); ?>   <!-- タイムゾーンの設定をSessionManagerに追加してな-->

<head>
    <meta charset="UTF8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>サービスマスター更新</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <h1><img src="img/logo3.png"></h1>
</head>

<body>


    <!--ログイン情報-->
    <div>
        <?php
        //ログイン済みの場合
        session_cache_limiter('none');
        session_start();
        if (isset($_SESSION['STAFF_ID']) && isset($_SESSION['LAST_NAME']) && isset($_SESSION['FIRST_NAME']) && isset($_SESSION['STORE_ID'])) {

            include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/SessionManager.php');

        ?>
    </div>


    <?php
            /*************************************************************************************************
        データベースの接続(PDO) && XSS対策 && clickjacking対策 
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


    ?>


    <?php
            $pageFlag = 0;
            $error = validation($_POST);

            if (!empty($_POST['confirm'])  && empty($error)) {
                $pageFlag = 1;
            }

            if (!empty($_POST['update'])) {
                $pageFlag = 2;
            }
    ?>

    <!-- 更新ボタンが空ではなく、且つエラーが空ではなかったら -->
    <?php if (!empty($_POST['confirm']) && !empty($error)) : ?>
        <ul class="error">
            <!-- $errorは連想配列なのでforeachで分解していく -->
            <?php foreach ($error as $value) : ?>
                <!-- 分解したエラー文をlistの中に表示していく -->
                <li><?= $value; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <script>
        function getid(store_id) {
            var value = store_id.options[idx].value;
            document.getElementById("store_id").textcontent = value;
        }
    </script>



    <?php if ($pageFlag === 0) : ?>

        <?php
                try {

                    $pdo = GetDb();

                    //店舗セレクトボックス
                //    $sql = "SELECT * FROM m_store ";
                //    $stmt = $pdo->prepare($sql);
                //    $stmt->execute();

                    //レコード件数
                //    $row_count = $stmt->rowCount();

                    //連想配列で取得
                //    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //        $rows[] = $row;
                //    }

                    $stmt = $pdo->prepare('SELECT * FROM m_service JOIN m_store using(`store_id`) WHERE service_id = :service_id AND store_name = :store_name');
                    $stmt->execute(array(':service_id' => $_POST["service_id"], ':store_name' => $_POST["store_name"]));
                    $result = 0;
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗：<br>' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;

                $store_id = $result['store_id'];
                $store_name = $result['store_name'];
                $service_id = $result['service_id'];
                $service_name = $result['service_name'];
                $service_title = $result['service_title'];
                $service_flg = $result['service_flg'];
                $frequency = $result['frequency'];
                $month = $result['month'];
                $target = $result['target'];
                $max_cnt = $result['max_cnt'];
                $overview = $result['overview'];
                $price = $result['price'];
                $open_flg = $result['open_flg'];
                $yoyaku_flg = $result['yoyaku_flg'];
        ?>
    <body>
        <div class="center">
            <div class="sheet">
            <h2>サービスマスター更新</h2>
            <ul class="service">
            <form action="" method="post">

            <!-- 更新は店舗固定 -->
                <label id="label">店舗: </label>
                <li class="service">
                <input type="hidden" value="<?= $store_id?>" name="store_id">
                <input type="text" readonly value="<?= $store_name?>" name="store_name">
            
            <!--    <select id="store"  class="input" name="store_id" onchange='getid(this);'>";    -->
                    <?php
               //     if ($row_count != 0) {
               //         foreach ($rows as $row) {
               //             $store_name_r = $row['store_name'];
               //             $store_id_r   = $row['store_id'];

               //             if ($store_name_r == $store_name) {
               //                 echo " <option value=\"" . $store_id . "\" selected>" . $store_name . "</option>\n";
               //             } else {
               //                 echo " <option value=\"" . $store_id_r . "\">" . $store_name_r . "</option>\n";
               //             }
               //         }
               //     }

                    ?>
            <!--    </select>   -->
                </li>
                <br>
                <br>

                <lable id="label">サービス名:</lable>
                <li class="service">
                <select name="service_name" size="1" id="service" class="input">
                    <option value="<?= $service_name ?>"><?= $service_name ?></option>
                    <option value="就職ガイドコース">就職ガイドコース</option>
                    <option value="まなクルプログラムコース">まなクルプログラムコース</option>
                    <option value="まなクルExcelコース">まなクルExcelコース</option>
                    <option value="まなクルWordコース">まなクルWordコース</option>
                    <option value="まなクルキッズ英会話コース">まなクルキッズ英会話コース</option>
                    <option value="まなクルキッズ音楽コース">まなクルキッズ音楽コース</option>
                    <option value="まなクルEnglishコース">まなクルEnglishコース</option>
                    <option value="まなクル特別コース">まなクル特別コース</option>
                    <option value="その他サービス" id="90">その他</option>
                </select>
                </li>
                <br>
                <br>

                <label id="label">タイトル:</label>
                <li class="service">
                <input type="text" class="input" name="service_title" placeholder="(講座名/職種)" value="<?= $service_title ?>">
                </li>
                <br>
                <br>

                <label id="label">サービス単位:</label>
                <li class="service">
                <label for="service_flg" class="btn-radio">
                    <input type="radio" name="service_flg" value="0" <?php if ($result['service_flg'] == 0)  echo "checked" ?> id="service_flg" 　>

                    <svg width="20px" height="20px" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="9"></circle>
                        <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                        <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                    </svg>
                    サービス
                </label>

                <label for="time_flg" class="btn-radio">
                    <input type="radio" name="service_flg" value="1" <?php if ($result['service_flg'] == 1)  echo "checked" ?> id="time_flg" 　>

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
                <input type="text" class="input" name="frequency" maxlength="15" value="<?= $frequency ?>"></a><br>
                </li>
                <br>
                <br>

                <label id="label">月数:</label>
                <li class="service">
                <select name="month" size="1" id="month" class="input">
                    <option value="<?= $month ?>"><?= $month ?></option>
                    <option value="1">1ヶ月</option>
                    <option value="2">2ヶ月</option>
                    <option value="3">3ヶ月</option>
                    <option value="4">4ヶ月</option>
                    <option value="5">5ヶ月</option>
                    <option value="6">6ヶ月</option>
                    <option value="7">7ヶ月</option>
                    <option value="8">8ヶ月</option>
                    <option value="9">9ヶ月</option>
                    <option value="10">10ヶ月</option>
                    <option value="11">11ヶ月</option>
                    <option value="12">12ヶ月</option>
                    <option value="13">期限なし</option>
                </select>
                </li>
                <br>
                <br>

                <label id="label">対象者:</label>
                <li class="service">
                <input type="text" class="input" name="target" value="<?= $target ?>">
                </li>
                <br>
                <br>

                <label id="label">最大予約者数:</label>
                <li class="service">
                <input type="text" class="input" name="max_cnt" value="<?= $max_cnt ?>">
                </li>
                <br>
                <br>

                <label id="label">概要:</label>
                <li class="service">
                <textarea name="overview" class="input" maxlength="200"><?= $overview ?></textarea>
                </li>
                <br>
                <br>

                <label id="label">料金(円):</label>
                <li class="service">
                <input type="text" class="input" data-type="number" name="price" maxlength="8" value="<?= $price ?>">
                </li>
                <br>
                <br>

                <label id="label">開始状態:</label>
                <li class="service">
                <label for="open" class="btn-radio">
                    <input type="radio" name="open_flg" value="1" <?php if ($result['open_flg'] == 1)  echo "checked" ?> id="open">

                    <svg width="20px" height="20px" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="9"></circle>
                        <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                        <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
                    </svg>
                    開始中
                </label>

                <label for="close" class="btn-radio">
                    <input type="radio" name="open_flg" value="0" <?php if ($result['open_flg'] == 0)  echo "checked" ?> id="close">

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

                <input type="hidden" name="service_id" value="<?= $service_id ?>">
                <input type="hidden" name="store_name" value="<?= $store_name?>"> 
                <input class="button" type="submit" name="confirm" value="更新">
                <a href="service_m_list.php"><input type="button" class="button" title="return" value="戻る"> </form>

        </div>
     </div>
</body>

</html>

<?php endif; ?>



<?php if ($pageFlag === 1) : ?>

    <body>
        <div class="center">

            <h2>サービスマスター更新確認</h2>

            <div class="page">
                <?php

                $store_id = html($_POST['store_id']);
                $store_name = html($_POST['store_name']);
                $service_id = html($_POST['service_id']);
                $store_id = html($_POST['store_id']);
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

                echo 'タイトル(講座名/職種)：  ';
                echo $service_title;
                echo '<hr><br>';

                echo 'サービス単位：  ';
                if ($service_flg == 0) {
                    echo 'サービス単位';
                } elseif ($service_flg == 1) {
                    echo '時間単位';
                };
                echo '<hr><br>';

                echo 'コマ数:  ';
                echo $frequency;
                echo '<hr><br>';

                echo '月数：  ';
                echo $month;
                echo '<hr><br>';

                echo '対象者：  ';
                echo $target;
                echo '<hr><br>';

                echo '最大予約者数：  ';
                echo $max_cnt;
                echo '<hr><br>';

                echo '概要：  ';
                echo $overview;
                echo '<hr><br>';

                echo '料金（円）：  ';
                echo $price;
                echo '<hr><br>';

                echo '開始状態：  ';
                if ($open_flg == 1) {
                    echo '開始中';
                } elseif ($open_flg == 0) {
                    echo '停止中';
                };

                 //予約フラグの設定

                 if ($open_flg == 1){

                    $yoyaku_flg = $open_flg;    //予約可

                } elseif ($open_flg == 0){

                    $yoyaku_flg = $open_flg;    //予約不可

                }



                echo '<form method="POST" action="">';
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
                echo '<input type="hidden" name="service_id" value="' . $service_id . '">';

                ?>
                <br>
            </div>
            <input class="button" type="submit" name="update" value="確定" onclick="return confirm('更新してもよろしいですか？');" />
            <input class="button" type="button" onclick="history.back()" value="戻る">
            </form>

        </div>
    </body>

<?php endif; ?>

<?php if ($pageFlag === 2) : ?>
    <?php

                $store_id = $_POST['store_id'];     //WHERE
                $service_id = $_POST['service_id']; //WHERE
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

                try {
                    $pdo = GetDb();

                    $sql = "UPDATE m_service SET
                    service_name = :service_name,
                    service_title = :service_title,
                    service_flg = :service_flg,
                    frequency = :frequency,
                    month = :month,
                    target = :target,
                    max_cnt = :max_cnt,
                    overview = :overview,
                    price = :price,
                    open_flg = :open_flg,
                    yoyaku_flg = :yoyaku_flg
                    WHERE store_id = :store_id
                    AND service_id = :service_id";

                    $stmt = $pdo->prepare($sql);
                    $array = array(':store_id' => $store_id, ':service_id' => $service_id, ':service_name' => $service_name, ':service_title' => $service_title, 'service_flg' => $service_flg, ':frequency' => $frequency, ':month' => $month, ':target' => $target, ':max_cnt' => $max_cnt, ':overview' => $overview, ':price' => $price, ':open_flg' => $open_flg, ':yoyaku_flg' => $yoyaku_flg);
                    $stmt->execute($array);

                    header('location:service_m_list.php');
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗：<br>' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;

    ?>
<?php endif; ?>

<?php
        } else {
            //ログインしていません。
            echo "ログインしてください。<br><br>";
            echo '<a href="c:/web/git/MANAKURU_WEB/manakuru_yoyaku/login/login.php">ログインへ</a>';
        }
?>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>