<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>サービスマスター</title>
    <!-- JS -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#myTable").tablesorter();
            $("#myTable").paginate({
                rows: 10,
                position: "bottom",
                jqueryui: true,
                showIfLess: false
            });
        });
    </script>

    <!-- 店舗検索 -->


    <script>
        function getid(store_id) {
            var value = store_id.options[idx].value;
            document.getElementById("store_id").textcontent = value;
        }
    </script>

    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/table.css" type="text/css">


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
            データベースの接続(PDO)  && clickjacking対策
             *************************************************************************************************/
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
                $store_id = $_SESSION['STORE_ID'];
                //親サービスリスト
                $sql = "SELECT * 
                FROM m_service RIGHT JOIN m_store 
                ON m_service.store_id = m_store.store_id
                WHERE m_service.store_id = $store_id
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                //レコード件数
                $list_count = $stmt->rowCount();

                //連想配列で取得
                while ($list = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $lists[] = $list;
                }


                if ($row_count == 0 || $list_count == 0) {
                    echo '<br />';
                    echo '<br />';
                    echo '<FONT COLOR="RED"> 該当するデータはありませんでした </FONT>';
                    echo '<br />';
                }
            } catch (PDOException $e) {
                echo 'データベースに接続失敗：' . $e->getMessage();
            }

            // 接続を閉じる
            $pdo = null;

?>


<?php
            $pageFlag = 0;
            //           if (!empty($_POST['s'])) {
            //               $pageFlag = 1;
            //           }

            //           if (!empty($_POST['s1'])) {
            //               $pageFlag = 1;
            //           }

            if (!empty($_POST['s_service'])) {
                $pageFlag = 1;
            }

?>

<body>
    <?php if ($pageFlag === 0) : ?>


        <p>サービスマスター</p>

        <!--サービス検索-->

        <form action="" method="post" id="search">

            <input type="search" name="service_name" placeholder="サービス検索">

            <select id="store_name" name="store_name">";
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

                        if ($store_name == ($_SESSION['STORE_NAME'])) {
                            echo " <option value=\"" . $store_name . "\" selected>" . $store_name . "</option>\n";
                        } else {
                            echo " <option value=\"" . $store_name . "\">" . $store_name . "</option>\n";
                        }
                    }
                }
                ?>
            </select>

            <input type="submit" name="s_service" class="button6" value="検索">
        </form>



        <form action="service_m_register.php" method="POST">
            <input type="hidden" name="store_id" value="<?= $store_id ?>">
            <input type="submit" class="button2" title="Insert" value="新規登録"></input>
        </form>

        <!--    <div class="center">    -->

        <div class="scroll">
            <table id="myTable" class="zebra">


                <thead>
                    <tr>
                        <!--    <th>店舗名</th>     -->
                        <th>サービスID</th>
                        <th>サービス名</th>
                        <th>タイトル(講座名/職種)</th>
                        <th>トータル時間</th>
                        <th>単位</th>
                        <th>コマ数</th>
                        <th>月数</th>
                        <th>対象者</th>
                        <th>最大予約者数</th>
                        <th>概要</th>
                        <th>料金(円)</th>
                        <th>開始</th>
                        <th>予約</th>
                        <th>更新</th>
                        <th>削除</th>
                </thead>


                <tbody>
                    <?php
                    if ($list_count != 0) {
                        foreach ($lists as $list) {
                            //変数定義
                            $store_name = $list['store_name'];
                            $store_id = $list['store_id'];
                            $service_id = $list['service_id'];
                            $service_name = $list['service_name'];
                            $service_title = $list['service_title'];
                            //$service_time=$list['service_detail_time'];
                            $service_flg = $list['service_flg'];
                            $frequency = $list['frequency'];
                            $month = $list['month'];
                            $target = $list['target'];
                            $max_cnt = $list['max_cnt'];
                            $overview = $list['overview'];
                            $price = $list['price'];
                            $open_flg = $list['open_flg'];
                            $yoyaku_flg = $list['yoyaku_flg'];

                            if ($store_name == h($_SESSION['STORE_NAME'])) {

                                try {
                                    //子サービスマスターから時間の合計を求める

                                    $pdo = GetDb();
                                    $sql = "SELECT SUM(service_detail_time) FROM m_service_detail where store_id=$store_id AND service_id=$service_id";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();


                                    //レコード件数
                                    $rowtime_count = $stmt->rowCount();

                                    //連想配列で取得
                                    while ($rowtime = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $rowtimes[] = $rowtime;
                                    }
                                } catch (PDOException $e) {
                                    echo 'データベースに接続失敗：' . $e->getMessage();
                                }

                                // 接続を閉じる
                                $pdo = null;


                                if ($rowtime_count != 0) {
                                    foreach ($rowtimes as $rowtime) {
                                        $service_detail_time = $rowtime['SUM(service_detail_time)'];
                                    }
                                }

                    ?>

                                <tr>
                                    <!--    <td><?= $store_name; ?></td>     -->
                                    <td id="num"><?= $service_id; ?></td>
                                    <td><?= $service_name; ?></td>
                                    <td><a href="service_m_detail_list.php?store_id=<?= $store_id; ?>&service_id=<?= $service_id; ?>"><input class="button3" type="button" value="<?= $service_title; ?>"></input></a></td>
                                    <td id="num"><?= $service_detail_time ?></td>
                                    <td><?php if ($service_flg == 0) {
                                            echo 'サービス単位';
                                        } elseif ($service_flg == 1) {
                                            echo '時間単位';
                                        } elseif ($service_flg == NULL) {
                                            echo '';
                                        } ?></td>
                                    <td id="num"><?= $frequency; ?></td>
                                    <td><?= $month; ?></td>
                                    <td><?= $target; ?></td>
                                    <td id="num"><?= $max_cnt ?></td>
                                    <td><?= $overview; ?></td>
                                    <td id="num"><?= $price; ?></td>
                                    <td><?php if ($open_flg == 1) {
                                            echo '開始中';
                                        } elseif ($open_flg == 0) {
                                            echo '停止中';
                                        } elseif ($open_flg == NULL) {
                                            echo '';
                                        } ?></td>
                                    <td><?php if ($yoyaku_flg == 1) {
                                            echo '可';
                                        } elseif ($yoyaku_flg == 0) {
                                            echo '不可';
                                        } elseif ($yoyaku_flg == NULL) {
                                            echo '';
                                        } ?></td>

                                    <td>
                                        <form action="service_m_update.php" method="post">
                                            <input type="submit" class="button4" title="Update" value="更新"></input>
                                            <input type="hidden" name="service_id" value="<?= $list['service_id'] ?>">
                                            <input type="hidden" name="store_name" value="<?= $list['store_name'] ?>">
                                        </form>
                                    </td>

                                    <td>
                                        <form action="service_m_delete.php" method="post">
                                            <input type="submit" class="button5" title="delete" value="削除 "></input>
                                            <input type="hidden" name="service_id" value="<?= $list['service_id'] ?>">
                                            <input type="hidden" name="store_name" value="<?= $list['store_name'] ?>">
                                        </form>
                                    </td>

                                </tr>
                    <?php
                            }
                        }
                    }
                    ?>
                </tbody>

            </table>

        </div>
        </div>
        <br><br>
        <a href="../../menu.php"><input type="button" class="button" value="戻る"></a>
    <?php endif; ?>


    <?php if ($pageFlag === 1) : ?>

        <?php

                if (isset($_POST['store_name'])) {

                    $store_name_s = $_POST['store_name'];
                } else {

                    $store_name_s = "";
                }

                if (isset($_POST['service_name'])) {

                    $s_service = $_POST['service_name'];
                } else {

                    $s_service = "";
                }

                try {

                    if (!empty($store_name_s)) {
                        $pdo = GetDb();
                        $sql = "SELECT * FROM m_service RIGHT JOIN m_store ON m_service.store_id = m_store.store_id WHERE  store_name = :store_name";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute(array(':store_name' => $store_name_s));

                        //レコード件数
                        $search_count = $stmt->rowCount();

                        //連想配列で取得
                        while ($search = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $searchs[] = $search;
                        }

                        $all_count = 0;
                        $service_cnt = 0;
                    } else {

                        $pdo = GetDb();
                        $sql = "SELECT * FROM m_service RIGHT JOIN m_store ON m_service.store_id = m_store.store_id WHERE m_service.store_id !=0 ";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        //レコード件数
                        $all_count = $stmt->rowCount();

                        //連想配列で取得
                        while ($alldata = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $alldatas[] = $alldata;
                        }

                        $search_count = 0;
                        $service_cnt = 0;
                    }

                    //$service_cnt=0;

                    if (!empty($s_service)) {

                        $sql = "SELECT * FROM `m_service` JOIN `m_store`USING(`store_id`) WHERE `service_name` LIKE '%$s_service%'";

                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        $service_cnt = $stmt->rowCount();

                        //連想配列で取得
                        while ($s_search = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $services[] = $s_search;
                        }
                    }

                    if ($search_count == 0 && $service_cnt == 0 && $all_count == 0) {
                        echo '<br />';
                        echo '<br />';
                        echo '<FONT COLOR="RED"> 該当するデータはありませんでした </FONT>';
                        echo '<br />';
                    }
                } catch (PDOException $e) {
                    echo 'データベースに接続失敗：' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;


        ?>

        <br>
        <p>サービスマスター</p>



        <div>
            <!--サービス検索-->

            <form action="" method="post">

                <input type="search" name="service_name" placeholder="サービス名検索">

                <select id="store_name" name="store_name">";
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
                            } else {
                                echo " <option value=\"" . $store_name . "\">" . $store_name . "</option>\n";
                            }
                        }
                    }
                    ?>
                </select>

                <input type="submit" name="s_service" class="button6" value="検索">
            </form>

            <br>

            <form action="service_m_register.php" method="POST">
                <input type="hidden" name="store_id" value="<?= $store_id ?>">
                <input type="submit" class="button2" title="Insert" value="新規登録"></input>

            </form>
            <br>

            <?php

                if (!empty($_POST['service_name'])) {

                    echo "<a>サービス検索結果:  $service_cnt 件</a>";
                } elseif (!empty($_POST['store_name'])) {

                    echo "<a>サービス検索結果: $search_count 件</a>";
                } else {

                    $s_service = 0;
                }

                if ($all_count == 0 && $search_count == 0 && $service_cnt == 0) {   //要修正

                    echo "サービスがありません";
                }

            ?>

            <!--    <div class="center">    -->
            <div class="scroll">
                <table id="myTable" class="zebra">


                    <thead>
                        <tr>
                            <!--    <th>店舗名</th>     -->
                            <th>サービスID</th>
                            <th>サービス名</th>
                            <th>タイトル(サービス名/職種)</th>
                            <th>トータル時間</th>
                            <th>単位</th>
                            <th>コマ数</th>
                            <th>月数</th>
                            <th>対象者</th>
                            <th>最大予約者数</th>
                            <th>概要</th>
                            <th>料金(円)</th>
                            <th>開始</th>
                            <th>予約</th>
                            <th>更新</th>
                            <th>削除</th>
                    </thead>


                    <tbody>
                        <?php



                        if ($search_count != 0 && $s_service == null) {
                            foreach ($searchs as $search) {
                                //変数定義
                                $store_name = $search['store_name'];
                                $store_id = $search['store_id'];
                                $service_id = $search['service_id'];
                                $service_name = $search['service_name'];
                                $service_title = $search['service_title'];
                                //$service_time=$search['service_detail_time'];
                                $service_flg = $search['service_flg'];
                                $frequency = $search['frequency'];
                                $month = $search['month'];
                                $target = $search['target'];
                                $max_cnt = $search['max_cnt'];
                                $overview = $search['overview'];
                                $price = $search['price'];
                                $open_flg = $search['open_flg'];
                                $yoyaku_flg = $search['yoyaku_flg'];


                                if (!empty($service_id)) {
                                    try {
                                        //子サービスマスターから時間の合計を求める

                                        $pdo = GetDb();
                                        $sql = "SELECT SUM(service_detail_time) FROM m_service_detail where store_id=$store_id AND service_id=$service_id ";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();

                                        //レコード件数
                                        $rowtime_count = $stmt->rowCount();

                                        //連想配列で取得
                                        while ($rowtime = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $rowtimes[] = $rowtime;
                                        }
                                    } catch (PDOException $e) {
                                        echo 'データベースに接続失敗：' . $e->getMessage();
                                    }


                                    // 接続を閉じる
                                    $pdo = null;

                                    if ($rowtime_count != 0) {
                                        foreach ($rowtimes as $rowtime) {
                                            $service_detail_time = $rowtime['SUM(service_detail_time)'];
                                        }
                                    }



                        ?>
                                    <!--店舗セレクト時-->


                                    <tr>
                                        <!--    <td><?= $store_name; ?></td>     -->
                                        <td id="num"><?= $service_id; ?></td>
                                        <td><?= $service_name; ?></td>
                                        <td><a href="service_m_detail_list.php?store_id=<?= $store_id; ?>&service_id=<?= $service_id; ?>"><input class="button3" type="button" value="<?= $service_title; ?>"></input></a></td>
                                        <td id="num"><?php if (!empty($service_detail_time)) echo $service_detail_time ?></td>
                                        <td><?php if ($service_flg == 0) {
                                                echo 'サービス単位';
                                            } elseif ($service_flg == 1) {
                                                echo '時間単位';
                                            } elseif ($service_flg == NULL) {
                                                echo '';
                                            } ?></td>
                                        <td id="num"><?= $frequency; ?></td>
                                        <td><?= $month; ?></td>
                                        <td><?= $target; ?></td>
                                        <td id="num"><?= $max_cnt; ?></td>
                                        <td><?= $overview; ?></td>
                                        <td id="num"><?= $price; ?></td>
                                        <td><?php if ($open_flg == 1) {
                                                echo '開始中';
                                            } elseif ($open_flg == 0) {
                                                echo '停止中';
                                            } elseif ($open_flg == NULL) {
                                                echo '';
                                            } ?></td>
                                        <td><?php if ($yoyaku_flg == 1) {
                                                echo '可';
                                            } elseif ($yoyaku_flg == 0) {
                                                echo '不可';
                                            } elseif ($yoyaku_flg == NULL) {
                                                echo '';
                                            } ?></td>

                                        <td>
                                            <form action="service_m_update.php" method="post">
                                                <input type="submit" class="button4" title="update" value="更新"></input>
                                                <input type="hidden" name="service_id" value="<?= $search['service_id'] ?>">
                                                <input type="hidden" name="store_name" value="<?= $search['store_name'] ?>">
                                            </form>
                                        </td>

                                        <td>
                                            <form action="service_m_delete.php" method="post">
                                                <input type="submit" class="button5" title="delete" value="削除 "></input>
                                                <input type="hidden" name="service_id" value="<?= $search['service_id'] ?>">
                                                <input type="hidden" name="store_name" value="<?= $search['store_name'] ?>">
                                            </form>
                                        </td>

                                    </tr>
                        <?php
                                }
                            }
                        }

                        ?>

                        <?php

                        //全て表示

                        if ($all_count != 0 && $s_service == null) {

                            foreach ($alldatas as $alldata) {
                                //変数定義
                                $store_name = $alldata['store_name'];
                                $store_id = $alldata['store_id'];
                                $service_id = $alldata['service_id'];
                                $service_name = $alldata['service_name'];
                                $service_title = $alldata['service_title'];
                                //$service_time=$alldata['service_detail_time'];
                                $service_flg = $alldata['service_flg'];
                                $frequency = $alldata['frequency'];
                                $month = $alldata['month'];
                                $target = $alldata['target'];
                                $max_cnt = $alldata['max_cnt'];
                                $overview = $alldata['overview'];
                                $price = $alldata['price'];
                                $open_flg = $alldata['open_flg'];
                                $yoyaku_flg = $alldata['yoyaku_flg'];


                                if (!empty($service_id)) {
                                    try {
                                        //子サービスマスターから時間の合計を求める

                                        $pdo = GetDb();
                                        $sql = "SELECT SUM(service_detail_time) FROM m_service_detail where store_id=$store_id AND service_id=$service_id ";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();

                                        //レコード件数
                                        $rowtime_count = $stmt->rowCount();

                                        //連想配列で取得
                                        while ($rowtime = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $rowtimes[] = $rowtime;
                                        }
                                    } catch (PDOException $e) {
                                        echo 'データベースに接続失敗：' . $e->getMessage();
                                    }


                                    // 接続を閉じる
                                    $pdo = null;

                                    if ($rowtime_count != 0) {
                                        foreach ($rowtimes as $rowtime) {
                                            $service_detail_time = $rowtime['SUM(service_detail_time)'];
                                        }
                                    }



                        ?>
                                    <!--店舗セレクト時-->


                                    <tr>
                                        <!--    <td><?= $store_name; ?></td>     -->
                                        <td id="num"><?= $service_id; ?></td>
                                        <td><?= $service_name; ?></td>
                                        <td><a href="service_m_detail_list.php?store_id=<?= $store_id; ?>&service_id=<?= $service_id; ?>"><input class="button3" type="button" value="<?= $service_title; ?>"></input></a></td>
                                        <td id="num"><?php if (!empty($service_detail_time)) echo $service_detail_time ?></td>
                                        <td><?php if ($service_flg == 0) {
                                                echo 'サービス単位';
                                            } elseif ($service_flg == 1) {
                                                echo '時間単位';
                                            } elseif ($service_flg == NULL) {
                                                echo '';
                                            } ?></td>
                                        <td id="num"><?= $frequency; ?></td>
                                        <td><?= $month; ?></td>
                                        <td><?= $target; ?></td>
                                        <td id="num"><?= $max_cnt; ?></td>
                                        <td><?= $overview; ?></td>
                                        <td id="num"><?= $price; ?></td>
                                        <td><?php if ($open_flg == 1) {
                                                echo '開始中';
                                            } elseif ($open_flg == 0) {
                                                echo '停止中';
                                            } elseif ($open_flg == NULL) {
                                                echo '';
                                            } ?></td>
                                        <td><?php if ($yoyaku_flg == 1) {
                                                echo '可';
                                            } elseif ($yoyaku_flg == 0) {
                                                echo '不可';
                                            } elseif ($yoyaku_flg == NULL) {
                                                echo '';
                                            } ?></td>

                                        <td>
                                            <form action="service_m_update.php" method="post">
                                                <input type="submit" class="button4" title="update" value="更新"></input>
                                                <input type="hidden" name="service_id" value="<?= $alldata['service_id'] ?>">
                                                <input type="hidden" name="store_name" value="<?= $alldata['store_name'] ?>">
                                            </form>
                                        </td>

                                        <td>
                                            <form action="service_m_delete.php" method="post">
                                                <input type="submit" class="button5" title="delete" value="削除 "></input>
                                                <input type="hidden" name="service_id" value="<?= $alldata['service_id'] ?>">
                                                <input type="hidden" name="store_name" value="<?= $alldata['store_name'] ?>">
                                            </form>
                                        </td>

                                    </tr>
                        <?php
                                }
                            }
                        }

                        ?>

                        <!--サービス検索時-->

                        <?php

                        $cnt = 0;

                        if (empty($_POST{
                            'service_name'})) {

                            $service_cnt = 0;
                        }

                        if ($service_cnt) {       //サービス検索時

                            // foreach ($alldatas as $alldata) {

                            //   $store_name = $alldata['store_name'];

                            foreach ($services as $s_search) {

                                //変数定義
                                $store_name = $s_search['store_name'];
                                $store_id = $s_search['store_id'];
                                $service_id = $s_search['service_id'];
                                $service_name = $s_search['service_name'];
                                $service_title = $s_search['service_title'];
                                //$service_time=$s_search['service_detail_time'];
                                $service_flg = $s_search['service_flg'];
                                $frequency = $s_search['frequency'];
                                $month = $s_search['month'];
                                $target = $s_search['target'];
                                $max_cnt = $s_search['max_cnt'];
                                $overview = $s_search['overview'];
                                $price = $s_search['price'];
                                $open_flg = $s_search['open_flg'];
                                $yoyaku_flg = $s_search['yoyaku_flg'];


                                if (!empty($service_id)) {
                                    try {
                                        //子サービスマスターから時間の合計を求める

                                        $pdo = GetDb();
                                        $sql = "SELECT SUM(service_detail_time) FROM m_service_detail where store_id=$store_id AND service_id=$service_id ";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute();

                                        //レコード件数
                                        $rowtime_count = $stmt->rowCount();

                                        //連想配列で取得
                                        while ($rowtime = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            $rowtimes[] = $rowtime;
                                        }
                                    } catch (PDOException $e) {
                                        echo 'データベースに接続失敗：' . $e->getMessage();
                                    }


                                    // 接続を閉じる
                                    $pdo = null;

                                    if ($rowtime_count != 0) {
                                        foreach ($rowtimes as $rowtime) {
                                            $service_detail_time = $rowtime['SUM(service_detail_time)'];
                                        }
                                    }



                        ?>

                                    <tr>
                                        <!--    <td><?= $store_name; ?></td>     -->
                                        <td id="num"><?= $service_id; ?></td>
                                        <td><?= $service_name; ?></td>
                                        <td><a href="service_m_detail_list.php?store_id=<?= $store_id; ?>&service_id=<?= $service_id; ?>"><input class="button3" type="button" value="<?= $service_title; ?>"></input></a></td>
                                        <td id="num"><?php if (!empty($service_detail_time)) echo $service_detail_time ?></td>
                                        <td><?php if ($service_flg == 0) {
                                                echo 'サービス単位';
                                            } elseif ($service_flg == 1) {
                                                echo '時間単位';
                                            } elseif ($service_flg == NULL) {
                                                echo '';
                                            } ?></td>
                                        <td id="num"><?= $frequency; ?></td>
                                        <td><?= $month; ?></td>
                                        <td><?= $target; ?></td>
                                        <td id="num"><?= $max_cnt; ?></td>
                                        <td><?= $overview; ?></td>
                                        <td><?= $price; ?></td>
                                        <td><?php if ($open_flg == 1) {
                                                echo '開始中';
                                            } elseif ($open_flg == 0) {
                                                echo '停止中';
                                            } elseif ($open_flg == NULL) {
                                                echo '';
                                            } ?></td>
                                        <td><?php if ($yoyaku_flg == 1) {
                                                echo '可';
                                            } elseif ($yoyaku_flg == 0) {
                                                echo '不可';
                                            } elseif ($yoyaku_flg == NULL) {
                                                echo '';
                                            } ?></td>

                                        <td>
                                            <form action="service_m_update.php" method="post">
                                                <input type="submit" class="button4" title="update" value="更新"></input>
                                                <input type="hidden" name="service_id" value="<?= $s_search['service_id'] ?>">
                                                <input type="hidden" name="store_name" value="<?= $s_search['store_name'] ?>">
                                            </form>
                                        </td>

                                        <td>
                                            <form action="service_m_delete.php" method="post">
                                                <input type="submit" class="button5" title="delete" value="削除 "></input>
                                                <input type="hidden" name="service_id" value="<?= $s_search['service_id'] ?>">
                                                <input type="hidden" name="store_name" value="<?= $s_search['store_name'] ?>">
                                            </form>
                                        </td>

                                    </tr>
                        <?php


                                }
                            }
                        }

                        ?>
                    </tbody>

                </table>

                <!--   </div>  -->
            </div>
            <br><br>
            <a href="../../menu.php"><input type="button" class="button" value="戻る"></a>
            <!--class back add-->
        <?php endif; ?>





<?php

        }
    }
?>
</body>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>