<!DOCTYPE html>
<html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>
    <title>部屋マスター</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">
    <link rel="stylesheet" href="css/input.css" type="text/css">
    <link rel="stylesheet" href="css/border.css" type="text/css">
    <link rel="stylesheet" href="css/page.css" type="text/css">
    <link rel="stylesheet" href="css/radio.css" type="text/css">
    <link rel="stylesheet" href="css/checkbox.css" type="text/css">
    <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
</head>

<!--ログイン情報-->
<div class="center">
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

                //部屋リスト
                $sql = "SELECT * FROM m_store JOIN m_room using(`store_id`) ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                //レコード件数
                $list_count = $stmt->rowCount();

                //連想配列で取得
                while ($list = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $lists[] = $list;
                }
            } catch (PDOException $e) {
                echo 'データベースに接続失敗：' . $e->getMessage();
            }

            // 接続を閉じる
            $pdo = null;

?>

<?php
            $pageFlag = 0;
            if (!empty($_POST['s'])) {
                $pageFlag = 1;
            }

            if (!empty($_POST['s1'])) {
                $pageFlag = 1;
            }

?>

<body>

    <?php if ($pageFlag === 0) : ?>

        <label class="caption">部屋マスター</label>
        <!--店舗セレクトボックス-->

        <form method="POST" action="">
            <select id="store_name" name="store_name" class="input">
                <option value='0'>全ての店舗</option>

                <?php
                if (isset($_POST['store_name'])) {
                    $store_name_s = $_POST['store_name'];
                } elseif (isset($_GET['store_name'])) {
                    $store_name_s = $_GET['store_name'];
                } else {
                    $store_name_s = $_SESSION['STORE_NAME'];
                };


                if ($row_count != 0) {
                    foreach ($rows as $row) {
                        $store_name = $row['store_name'];
                        $store_id   = $row['store_id'];

                        if ($store_name == $store_name_s) {
                            echo " <option value=\"" . $store_name . "\" selected>" . $store_name . "</option>\n";
                            $tid = $store_id;
                        } else {
                            echo " <option value=\"" . $store_name . "\">" . $store_name . "</option>\n";
                        }
                    }
                }

                ?>
            </select>

            <input type="submit" name="s" value="絞り込む" id="button" class="button6">




        </form>



        <form action="<?php echo $href . "room_register.php" ?>" method="POST">
            <input type="hidden" name="store_id" value="<?= $tid ?>">
            <input type="submit" class="button7" title="Insert" value="新規登録"></input>
        </form>


        <div class="scroll">
            <table id="myTable" class="zebra">

                <thead>
                    <tr>
                        <!--<th>店舗ID</th>
                        <th>店舗名</th>-->
                        <th>部屋ID</th>
                        <th>部屋名</th>
                        <th>席数</th>
                        <th>貸出可否</th>
                        <!--<th>更新日</th>-->
                        <th style="width: 3%;">更新</th>
                        <th style="width: 3%;">削除</th>
                    </tr>
                </thead>


                <tbody>
                    <?php
                    if ($list_count != 0) {

                        foreach ($lists as $list) {
                            //変数定義
                            $store_id_list = $list['store_id'];
                            $store_name_list = $list['store_name'];
                            $room_name = $list['room_name'];
                            $room_id = $list['room_id'];
                            $room_name = $list['room_name'];
                            $seat = $list['seat'];
                            $loan = $list['loan'];
                            $updated_date = $list['updated_date'];

                            if ($store_name_list == $store_name_s) {
                    ?>

                                <tr>
                                    <!--<td><?php echo $store_id_list; ?></td>
                                    <td><?php echo  $store_name_list; ?></td>-->

                                    <td class="num"><?php echo $room_id; ?></td>

                                    <td><?php echo $room_name; ?></td>

                                    <td class="num"><?php echo $seat; ?></td>

                                    <td style="width: 3%;"><?php if ($loan == 1) {
                                                                echo '可';
                                                            } else {
                                                                echo '否';
                                                            } ?></td>
                                    <!--<td><?php echo $updated_date; ?></td>-->

                                    <td>
                                        <form action="<?php echo $href . "room_update.php" ?>" method="post">
                                            <input type="submit" title="Update" value="更新" class="button4"></input>
                                            <input type="hidden" name="store_id" value="<?= $list['store_id'] ?>">
                                            <input type="hidden" name="room_id" value="<?= $list['room_id'] ?>">
                                    </td>
                                    </form>

                                    <td>
                                        <form action="<?php echo $href . "room_delete.php" ?>" method="post">
                                            <input type="submit" title="delete " value="削除 " class="button5"></input>
                                            <input type="hidden" name="store_id" value="<?= $list['store_id'] ?>">
                                            <input type="hidden" name="room_id" value="<?= $list['room_id'] ?>">
                                    </td>
                                    </form>
                                </tr>
                    <?php
                            }
                        }
                    }

                    ?>
                </tbody>

            </table>
        </div>
        </br>
        </br>
        <a href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/menu.php">
            <input type="button" class="button" title="return" value="戻る"></input>
        </a>
        <br><br>
    <?php endif; ?>


    <?php if ($pageFlag === 1) : ?>

        <?php

                $store_name_s = $_POST['store_name'];

                try {

                    if (!empty($store_name_s)) {
                        $pdo = GetDb();
                        $sql = "SELECT * FROM m_store JOIN m_room using(`store_id`) WHERE  store_name = :store_name";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(':store_name' => $store_name_s));

                        //レコード件数
                        $search_count = $stmt->rowCount();

                        //連想配列で取得
                        while ($search = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $searchs[] = $search;
                        }
                    } else {

                        $pdo = GetDb();
                        $sql = "SELECT * FROM m_store JOIN m_room using(`store_id`)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        //レコード件数
                        $search_count = $stmt->rowCount();

                        //連想配列で取得
                        while ($search = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $searchs[] = $search;
                        }
                    }
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗：' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;

        ?>

        <label class="caption">部屋マスター</label>
        <!--店舗セレクトボックス-->

        <form method="POST" action="">
            <select id="store" name="store_name" class="input">
                <option value='0'>全ての店舗</option>

                <?php
                $tid = 0;
                if ($row_count != 0) {
                    foreach ($rows as $row) {
                        $store_name = $row['store_name'];
                        $store_id   = $row['store_id'];

                        if ($store_name == $store_name_s) {
                            echo " <option value=\"" . $store_name . "\" selected>" . $store_name . "</option>\n";
                            $tid = $store_id;
                        } else {
                            echo " <option value=\"" . $store_name . "\">" . $store_name . "</option>\n";
                        }
                    }
                }

                ?>

            </select>

            <input type="submit" name="s1" value="絞り込む" id="button" class="button6">

        </form>



        <form action="<?php echo $href . "room_register.php" ?>" method="POST">
            <input type="hidden" name="store_id" value="<?= $tid ?>">
            <input type="<?php if ($tid == 0) {
                                echo "hidden";
                            } else {
                                echo "submit";
                            } ?>" class="button7" title="Insert" value="新規登録"></input>
        </form>
        <div class="scroll">
            <table id="myTable" class="zebra">

                <thead>
                    <tr>
                        <!--<th>店舗ID</th>-->
                        <th>店舗名</th>
                        <th>部屋ID</th>
                        <th>部屋名</th>
                        <th>席数</th>
                        <th>貸出可否</th>
                        <!--<th>更新日</th>-->
                        <th>更新</th>
                        <th>削除</th>
                    </tr>
                </thead>


                <tbody>
                    <?php
                    if ($search_count != 0) {

                        foreach ($searchs as $search) {
                            //変数定義
                            $store_id_search = $search['store_id'];
                            $store_name_search = $search['store_name'];
                            $room_name = $search['room_name'];
                            $room_id = $search['room_id'];
                            $room_name = $search['room_name'];
                            $seat = $search['seat'];
                            $loan = $search['loan'];

                    ?>

                            <tr>
                                <!--<td><?php echo $store_id_search; ?></td>-->
                                <td><?php echo  $store_name_search; ?></td>
                                <td class="num"><?php echo $room_id; ?></td>
                                <td><?php echo $room_name; ?></td>
                                <td class="num"><?php echo $seat; ?></td>
                                <td><?php if ($loan == 1) {
                                        echo '可';
                                    } else {
                                        echo '否';
                                    } ?></td>
                                <!--<td><?php echo $search['updated_date']; ?></td>-->

                                <td class="center">
                                    <form action="<?php echo $href . "room_update.php" ?>" method="post">
                                        <input type="submit" title="Update" value="更新" class="button4"></input>
                                        <input type="hidden" name="store_id" value="<?= $search['store_id'] ?>">
                                        <input type="hidden" name="room_id" value="<?= $search['room_id'] ?>">
                                </td>
                                </form>

                                <td class="center">
                                    <form action="<?php echo $href . "room_delete.php" ?>" method="post">
                                        <input type="submit" title="delete " value="削除 " class="button5"></input>
                                        <input type="hidden" name="store_id" value="<?= $search['store_id'] ?>">
                                        <input type="hidden" name="room_id" value="<?= $search['room_id'] ?>">
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
        </br>
        </br>
        <a href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/menu.php">
            <input type="button" class="button" title="return" value="戻る"></input>
        </a>
        <br><br>

    <?php endif; ?>

<?php

        }
    }
?>
</body>

<footer> ©2020 株式会社ジェイテック</footer>

</html>