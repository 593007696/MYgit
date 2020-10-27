<!DOCTYPE html>
<html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>

<head>
  <meta charset="utf-8">

  <title>会員データ</title>

  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/table.css" type="text/css">
  <link rel="stylesheet" href="css/input.css" type="text/css">
  <link rel="stylesheet" href="css/border.css" type="text/css">
  <link rel="stylesheet" href="css/page.css" type="text/css">
  <link rel="stylesheet" href="css/radio.css" type="text/css">
  <link rel="stylesheet" href="css/checkbox.css" type="text/css">
  <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


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
      //POSTセキュリティー
      include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");
?>

<?php

      include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

      //clickjacking対策
      header('X-FRAME-OPTIONS: DENY');


?>

<?php

      if (isset($_POST['search'])) {
        $pageFlag = 1;
      } else {
        $pageFlag = 0;
      }

?>

<body>

  <?php if ($pageFlag === 0) :

        try {
          $pdo = GetDb();
          $sql = "SELECT * FROM `m_member` ORDER BY `m_member`.`withdrawal_date` ASC";
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


    <div class="center">


      <div class="page">

        <br>
        <label>検索条件を指定してください</label>
        <br><br>
        <form method="post" action="">


          <label for="member_id">ID:</label>

          <input type="text" class="input" name="member_id" id="member_id" style="margin-left:1%;display:inline;width:80px;">

          <label for="last_name">姓: </label>

          <input type="text" class="input" name="last_name" id="last_name" style="margin-left:1%;display:inline;width:80px;">

          <label for="first_name">名: </label>

          <input type="text" class="input" name="first_name" id="first_name" style="margin-bottom: 1%;margin-left:1%;display:inline;width:80px;">
          <br>
          <label>入退会:</label>

          <label for="outing" class="btn-radio">

            <input type="radio" name="withdrawal_date" id="outing" value="0">
            <svg width="20px" height="20px" viewBox="0 0 20 20">
              <circle cx="10" cy="10" r="9"></circle>
              <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
              <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
            </svg>
            <span>入会中</span>

          </label>


          <label for="ining" class="btn-radio">

            <input type="radio" name="withdrawal_date" id="ining" value="1">
            <svg width="20px" height="20px" viewBox="0 0 20 20">
              <circle cx="10" cy="10" r="9"></circle>
              <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
              <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
            </svg>
            <span>退会済</span>

          </label>

          <br><br>
          <input class="button2" type="submit" name="search" value="検索">


          <br><br>
        </form>
      </div>
    </div>




    <label class="caption">会員様情報一覧</label>
    <br>
    <a href="<?= $href .  "member_register.php" ?>">
      <input type="button" class="button4" title="Insert" value="新規登録" style="float:left;margin-left:1%"></input>
    </a>

    <div class="center">
      <a>合計件数：<?= $row_count ?>件</a>
    </div>

    <div class="scroll">
      <table class="zebra">

        <thead>
          <tr>
            <th>店舗ID</th>
            <th>会員ID</th>
            <th>姓</th>
            <th>名</th>
            <th>セイ</th>
            <th>メイ</th>
            <th>性別</th>
            <th>生年月日</th>
            <th>年齢</th>
            <th>郵便番号</th>
            <th>住所</th>
            <th>電話番号</th>
            <th>職業</th>
            <th>メール</th>
            <th>登録日</th>
            <th>更新日</th>

            <th>更新</th>
            <th>退会</th>
            <th>予約</th>
          </tr>
        </thead>

        <tbody>

          <?php

          if ($row_count != 0) {
            foreach ($rows as $row) {
              $withdrawal_date = $row["withdrawal_date"];
              $out = $withdrawal_date != null ? "hidden" : "submit";
              $color = $withdrawal_date != null ? 'style="background-color: red;"' : "";
          ?>

              <tr>
                <td class="num"><?= $row['store_id'] ?></td>
                <td <?= $color ?> class="num"><?= $row['member_id'] ?></td>
                <td><?= $row['last_name']; ?></td>
                <td><?= $row['first_name']; ?></td>
                <td><?= $row['sei']; ?></td>
                <td><?= $row['mei']; ?></td>

                <td>
                  <?php
                  if ($row['gender'] == 1) {
                    echo '男性';
                  } elseif ($row['gender'] == 2) {
                    echo '女性';
                  } elseif ($row['gender'] == 9) {
                    echo 'その他';
                  }
                  ?>
                </td>

                <td class="num"><?= $row['birthday']; ?></td>
                <td><?= $row['age']; ?></td>
                <td><?= $row['zipcode1'] . $row['zipcode2']; ?></td>
                <td><?= $row['prefectures'] . $row['ward'] . $row['address']; ?></td>
                <td><?= $row['tel']; ?></td>
                <td>
                  <?php if ($row['job'] == 1) {
                    echo '学生';
                  } elseif ($row['job'] == 2) {
                    echo '会社員';
                  } elseif ($row['job'] == 9) {
                    echo 'その他';
                  } ?>
                </td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['create_date']; ?></td>
                <td><?= $row['update_date']; ?></td>


                <td>
                  <form action="<?php echo $href . "member_edit.php" ?> " method="post">
                    <input type="<?= $out ?>" class="button4" title="Update" value="更新"></input>
                    <input type="hidden" name="member_id" value="<?= $row['member_id'] ?>">
                  </form>
                </td>


                <td>
                  <form action="<?php echo $href . "member_delete.php" ?>" method="post">
                    <input type="<?= $out ?>" name="delete" class="button5" title="delete " value="退会"></input>
                    <input type="hidden" name="member_id" value="<?= $row['member_id'] ?>">
                  </form>
                </td>

                <td>
                  <form action="../t_member_service/reservation.php" method="post">
                    <input type="<?= $out ?>" class="button2" title="reservation" value="予約"></input>
                    <input type="hidden" name="member_id" value="<?= $row['member_id'] ?>">
                  </form>
                </td>

              </tr>

          <?php }
          } ?>

        </tbody>

      </table>

    </div>
    <br>
    <a href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/main.php"><input type="button" class="button" value="戻る"></input> </a>

  <?php endif; ?>


  <?php if ($pageFlag === 1) : ?>

    <?php

        $member_id = $_POST['member_id'];

        $last_name = $_POST['last_name'];

        $first_name = $_POST['first_name'];

        $withdrawal_date = isset($_POST["withdrawal_date"]) ? ($_POST["withdrawal_date"] == "0" ? "NULL" : "NOT NULL") : "";



        $seach_date = array();
        $member_id != "" ? $seach_date[] = "member_id = '" . $member_id . "'" : "";

        $last_name != "" ?  $seach_date[] = "last_name = '" . $last_name . "'" : "";

        $first_name != "" ?  $seach_date[] = "first_name = '" . $first_name . "'" : "";

        $withdrawal_date != "" ?  $seach_date[] = "withdrawal_date IS " . $withdrawal_date : "";




        $sql_p1 = "SELECT * FROM m_member ";

        $sql_p2 = implode(" AND ", $seach_date);
        $sql_p2 = $sql_p2 != "" ? "WHERE " . $sql_p2 : "";
        $sql =  $sql_p1 . $sql_p2;


        try {
          $pdo = GetDb();


          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $row_count = $stmt->rowCount();

          //連想配列で取得
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $rows[] = $row;
          }
        } catch (PDOException $e) {
          echo 'データベースに接続失敗：' . $e->getMessage();
        }

        $pdo = null;

    ?>

    <br>

    <div class="center">

      <?php

        if ($row_count === 0) {

          echo '<FONT COLOR="RED"> 該当するデータはありませんでした </FONT>';
        } else {
          echo "<a>検索結果 :$row_count 件</a>";
        }


      ?>

      <div class="scroll">
        <table id="myTable" class="zebra">

          <thead>
            <tr>
              <th>店舗ID</th>
              <th>会員ID</th>
              <th>姓</th>
              <th>名</th>
              <th>セイ</th>
              <th>メイ</th>
              <th>性別</th>
              <th>生年月日</th>
              <th>年齢</th>
              <th>郵便番号</th>
              <th>住所</th>
              <th>電話番号</th>
              <th>職業</th>
              <th>メール</th>
              <th>登録日</th>
              <th>更新日</th>
              <th>退職日</th>
              <th>更新</th>
              <th>退会</th>
              <th>予約</th>
            </tr>
          </thead>

          <tbody>

            <?php

            if ($row_count != 0) {
              foreach ($rows as $row) {
                $withdrawal_date = $row["withdrawal_date"];
                $out = $withdrawal_date != null ? "hidden" : "submit";
            ?>

                <tr>
                  <td class="num"><?= $row['store_id'] ?></td>
                  <td class="num"><?= $row['member_id'] ?></td>
                  <td><?= $row['last_name']; ?></td>
                  <td><?= $row['first_name']; ?></td>
                  <td><?= $row['sei']; ?></td>
                  <td><?= $row['mei']; ?></td>

                  <td>
                    <?php
                    if ($row['gender'] == 1) {
                      echo '男性';
                    } elseif ($row['gender'] == 2) {
                      echo '女性';
                    } elseif ($row['gender'] == 9) {
                      echo 'その他';
                    }
                    ?>
                  </td>

                  <td><?= $row['birthday']; ?></td>
                  <td><?= $row['age']; ?></td>
                  <td><?= $row['zipcode1'] . $row['zipcode2']; ?></td>
                  <td><?= $row['prefectures'] . $row['ward'] . $row['address']; ?></td>
                  <td><?= $row['tel']; ?></td>
                  <td>
                    <?php if ($row['job'] == 1) {
                      echo '学生';
                    } elseif ($row['job'] == 2) {
                      echo '会社員';
                    } elseif ($row['job'] == 9) {
                      echo 'その他';
                    } ?>
                  </td>
                  <td><?= $row['email']; ?></td>
                  <td><?= $row['create_date']; ?></td>
                  <td><?= $row['update_date']; ?></td>
                  <td><?php echo $row['withdrawal_date']; ?></td>

                  <td>
                    <form action="<?php echo $href . "member_edit.php" ?> " method="post">
                      <input type="<?= $out ?>" class="button2" title="Update" value="更新"></input>
                      <input type="hidden" name="member_id" value="<?= $row['member_id'] ?>">
                    </form>
                  </td>


                  <td>
                    <form action="<?php echo $href . "member_delete.php" ?>" method="post">
                      <input type="<?= $out ?>" name="delete" class="button2" title="delete " value="退会"></input>
                      <input type="hidden" name="member_id" value="<?= $row['member_id'] ?>">
                    </form>
                  </td>

                  <td>
                    <form action="../t_member_service/reservation.php" method="post">
                      <input type="<?= $out ?>" class="button2" title="reservation" value="予約"></input>
                      <input type="hidden" name="member_id" value="<?= $row['member_id'] ?>">
                    </form>
                  </td>

                </tr>


            <?php
              }
            }
            ?>

          </tbody>

        </table>
      </div>

      <br><br>
      <a href="<?= $href . "member_list.php" ?>">
        <input type="button" class="button" value="戻る"></input>
      </a>
    </div>


  <?php endif; ?>



<?php

    }
  }
?>
</body>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>