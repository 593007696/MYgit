<!DOCTYPE html>
<html>

<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>
    <meta charset="utf-8">
    <title>店舗マスター</title>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="../../common/js/jquery.tablesorter.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="../../common/js/jquery.metadata.js" type="text/javascript" charset="utf-8"></script>
    <script src="../../common/js/PaginateMyTable.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#myTable").tablesorter();
            $("#myTable").paginate({
                rows: 5,
                position: "bottom",
                jqueryui: true,
                showIfLess: false
            });
        });
    </script>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
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

                //データベース接続
                include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

                //clickjacking対策
                header('X-FRAME-OPTIONS: DENY');

    ?>


    <?php
                try {
                    $pdo = GetDb();

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
                    echo 'データベースに接続失敗：' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;

    ?>
    <label class="caption">店舗マスター</label>
    <form action="<?php echo $href . "store_register.php" ?>" method="POST">
        <input type="submit" class="button6" title="Insert" value="新規登録"></input>
    </form>
    <div class="scroll">
        <table id="myTable" class="zebra">



            <thead>

                <th>店舗ID</th>
                <th>店舗名</th>
                <th>最寄駅</th>
                <th>郵便番号</th>
                <th>住所</th>
                <th>電話番号</th>
                <th>FAX番号</th>
                <th>地図URL</th>
                <!--<th>更新日</th>-->
                <th style="width: 3%;">更新</th>
                <th style="width: 3%;">削除</th>

            </thead>


            <tbody>
                <?php
                if ($row_count != 0) {

                    foreach ($rows as $row) {
                        //変数定義
                        $store_id = $row['store_id'];
                        $store_name = $row['store_name'];
                        $station = $row['store_nearest_station'];
                        $zipcode1 = $row['zipcode1'];
                        $zipcode2 = $row['zipcode2'];
                        $prefectures = $row['prefectures'];
                        $ward = $row['ward'];
                        $address = $row['address'];
                        $map = $prefectures . $ward . $address;
                        $tel = $row['store_telephone_number'];
                        $fax = $row['store_fax_number'];
                        $url = $row['store_url'];
                        $updated_date = $row['updated_date'];
                ?>

                        <tr>

                            <td class="num"><?php echo $store_id; ?></td>

                            <td><?php echo  $store_name; ?></td>
                            <td><?php echo $station; ?></td>
                            <td><?php echo $zipcode1 . "-" . $zipcode2; ?></td>
                            <td><?php echo $prefectures . $ward . $address; ?></td>
                            <td><?php echo $tel; ?></td>
                            <td><?php echo $fax; ?></td>
                            <td><?php
                                if (!empty($map)) {
                                    $address2 = urlencode($map);
                                    $zoom = 15;
                                    $url = "http://maps.google.co.jp/maps?q={$address2}&z={$zoom}";
                                    echo "<a>【所在地】{$address}　<a href=\"{$url}\" target=\"_blank\">[地図]</a></a>";
                                }
                                ?></td>
                            <!--<td><?php echo $updated_date; ?></td>-->

                            <td>
                                <form action="<?php echo $href . "store_update.php" ?>" method="post">
                                    <input type="submit" title="Update" value="更新" class="button4"></input>
                                    <input type="hidden" name="store_id" value="<?= $row['store_id'] ?>">
                            </td>
                            </form>

                            <td>
                                <form action="<?php echo $href . "store_delete.php" ?>" method="post">
                                    <input type="submit" title="delete " value="削除 " class="button5"></input>
                                    <input type="hidden" name="store_id" value="<?= $row['store_id'] ?>">
                            </td>
                            </form>
                        </tr>
                <?php
                    }
                }

                ?>
            </tbody>

        </table>
    </div>

    <br>
    <br>
    <a href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/menu.php">
        <input class="button" type="button" value="戻る">
    </a>
</body>
<?php

            }
        }
?>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>