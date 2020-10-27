<!DOCTYPE html>
<?php
$path = __DIR__ . "\\";
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER["REQUEST_URI"];
$href = dirname($url) . "/";
?>
<html>

<head>
  <title>システムユーザーマスター</title>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/table.css" type="text/css">
  <link rel="stylesheet" href="css/input.css" type="text/css">
  <link rel="stylesheet" href="css/border.css" type="text/css">
  <link rel="stylesheet" href="css/page.css" type="text/css">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
      $pageFlag = 0;
      if (!empty($_POST['s'])) {
        $pageFlag = 1;
      }

      if (!empty($_POST['s1'])) {
        $pageFlag = 1;
      }

?>


<?php if ($pageFlag === 0) :
        try {
          $pdo = GetDb();

          $sql  = "SELECT * FROM  m_systemuser";

          $stmt = $pdo->prepare($sql);
          $stmt->execute();


          //レコード件数
          $row_count = $stmt->rowCount();

          //連想配列で取得
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
          }

          //店舗セレクトボックス
          $sql = "SELECT * FROM m_store ";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();
          $result = 0;
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
          echo 'データベースに接続失敗：' . $e->getMessage();
        }

        // 接続を閉じる
        $pdo = null;

?>

  <div class="center">

    <div class="page">


      <label>検索条件を指定してください</label>

      <form method="post" action="">

        <label for="staff_id">ID:</label>

        <input type="text" class="input" name="staff_id" id="staff_id" style="margin-top: 1%; margin-left:1%;display:inline;width:80px;">

        <label for="last_name">姓: </label>

        <input type="text" class="input" name="last_name" id="last_name" style="margin-left:1%;display:inline;width:80px;">

        <label for="first_name">名: </label>

        <input type="text" class="input" name="first_name" id="first_name" style="margin-bottom: 1%;margin-left:1%;display:inline;width:80px;">
        <br>

        <input class="button2" type="submit" name="s" value="検索" style="margin-bottom: 5%;">

      </form>
    </div>
  </div>

  <label class="caption">システムユーザーマスター</label>
  <br>
  <a href="<?php echo $href . "systemuser_register.php" ?>">
    <input type="button" class="button4" title="Insert" value="新規登録"></input>
  </a>


  <div class="scroll">
    <table id="myTable" class="zebra">

      <thead>
        <tr>
          <th>ユーザーID</th>
          <th>姓</th>
          <th>名</th>
          <th>性別</th>
          <th>生年月日</th>
          <th>年齢</th>
          <th>入社日</th>
          <th>所属店舗</th>
          <th>雇用形態</th>
          <th>役割</th>
          <th>講師</th>
          <th>郵便番号</th>
          <th>住所</th>
          <th>電話番号</th>
          <th>メールアドレス</th>
          <th>登録日</th>
          <th>更新日</th>
          <th>退職日</th>
          <th>更新</th>
          <th>削除</th>
        </tr>
      </thead>


      <tbody>
        <?php
        if ($row_count != 0) {
          foreach ($rows as $row) { ?>
            <tr>
              <td class="num"><?php echo $row['staff_id']; ?></td>
              <td><?php echo $row['last_name']; ?></td>
              <td><?php echo $row['first_name']; ?></td>
              <td><?php if ($row['gender'] == 1) {
                    echo '男性';
                  } elseif ($row['gender'] == 2) {
                    echo '女性';
                  } elseif ($row['gender'] == 9) {
                    echo 'その他';
                  } ?></td>
              <td><?php echo $row['birthday']; ?></td>
              <td class="num"><?php echo $row['age'];  ?></td>
              <td><?php echo $row['date_company']; ?></td>
              <td>
                <?php
                try {
                  $pdo = GetDb();

                  //店舗セレクトボックス
                  $sql = "SELECT store_name FROM m_store WHERE store_id =:store_id ";
                  $stmt = $pdo->prepare($sql);
                  $stmt->execute(array(':store_id' => $row['syozoku_store_id']));
                  $result = 0;
                  $result = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                  echo 'データベースに接続失敗：' . $e->getMessage();
                }

                // 接続を閉じる
                $pdo = null;

                echo $result['store_name'];
                ?>
              </td>
              <td><?php if ($row['type_employment'] == 1) {
                    echo '正社員';
                  } elseif ($row['type_employment'] == 2) {
                    echo 'アルバイト';
                  } elseif ($row['type_employment'] == 9) {
                    echo 'その他';
                  } ?></td>
              <td><?php if ($row['role'] == 1) {
                    echo '管理者';
                  } elseif ($row['role'] == 2) {
                    echo '講師';
                  } elseif ($row['role'] == 3) {
                    echo '受付';
                  } elseif ($row['role'] == 9) {
                    echo 'その他';
                  } ?></td>
              <td><?php if ($row['teacher'] == 1) {
                    echo '講師可 ';
                  } elseif ($row['teacher'] == 0) {
                    echo '講師不可';
                  } ?></td>
              <td><?php echo $row['zipcode1'] . $row['zipcode2']; ?></td>
              <td><?php echo $row['prefectures'] . $row['ward'] . $row['address']; ?></td>
              <td><?php echo $row['tel'];  ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['create_date']; ?></td>
              <td><?php echo $row['update_date']; ?></td>
              <td style="color:#FF0000"><?php echo $row['delete_date']; ?></td>

              <td>
                <form action="systemuser_update.php" method="post">
                  <input type="submit" title="Update" value="更新" class="button4"></input>
                  <input type="hidden" name="staff_id" value="<?= $row['staff_id'] ?>">
              </td>
              </form>

              <td>
                <form action="systemuser_delete.php" method="post">
                  <input type="submit" title="delete " value="削除 " class="button5"></input>
                  <input type="hidden" name="staff_id" value="<?= $row['staff_id'] ?>">
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

  <br>
  <a href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/menu.php">
    <input type="button" class="button" title="delete " value="戻る">
    </input> </a>


<?php endif; ?>


<?php if ($pageFlag === 1) : ?>

  <?php

        $staff_id = $_POST['staff_id'];

        $last_name = $_POST['last_name'];

        $first_name = $_POST['first_name'];

        $seach_date = array();
        $staff_id != "" ? $seach_date[] = "staff_id =:staff_id" : "";
        $last_name != "" ? $seach_date[] = "last_name =:last_name" : "";
        $first_name != "" ? $seach_date[] = "first_name =:first_name" : "";

        $sql_p1 = "SELECT * FROM `m_systemuser` ";

        $sql_p2 = implode(" AND ", $seach_date);
        $sql_p2 = $sql_p2 != "" ? "WHERE " . $sql_p2 : "";
        $sql = $sql_p1 . $sql_p2;

        $array = array();

        $staff_id != "" ? $array["staff_id"] = $staff_id : "";
        $last_name != "" ? $array["last_name"] = $last_name : "";
        $first_name != "" ? $array["first_name"] = $first_name : "";


        $pdo = GetDb();



        $stmt = $pdo->prepare($sql);
        $stmt->execute($array);
        $row_count = $stmt->rowCount();

        //連想配列で取得
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

          $rows[] = $row;
        }

        // 接続を閉じる
        $pdo = null;

  ?>


  <div>

    <br>
    <br>
  </div>

  <div class="center">
    <a>検索結果：<?= $row_count ?>件</a>
  </div>
  <br><br>
  <div class="scroll">
    <table id="myTable" class="zebra">

      <thead>
        <tr>
          <th>ユーザーID</th>
          <th>姓</th>
          <th>名</th>
          <th>性別</th>
          <th>生年月日</th>
          <th>年齢</th>
          <th>入社日</th>
          <th>所属店舗</th>
          <th>雇用形態</th>
          <th>役割</th>
          <th>講師</th>
          <th>郵便番号</th>
          <th>住所</th>
          <th>電話番号</th>
          <th>メールアドレス</th>
          <th>登録日</th>
          <th>更新日</th>
          <th>退職日</th>
          <th>更新</th>
          <th>削除</th>
        </tr>
      </thead>

      <tbody>
        <?php
        if ($row_count != 0) {
          foreach ($rows as $row) { ?>
            <tr>
              <td class="num"><?php echo $row['staff_id']; ?></td>
              <td><?php echo $row['last_name']; ?></td>
              <td><?php echo $row['first_name']; ?></td>
              <td><?php if ($row['gender'] == 1) {
                    echo '男性';
                  } elseif ($row['gender'] == 2) {
                    echo '女性';
                  } elseif ($row['gender'] == 9) {
                    echo 'その他';
                  } ?></td>
              <td><?php echo $row['birthday']; ?></td>
              <td><?php echo $row['age'];  ?></td>
              <td><?php echo $row['date_company']; ?></td>
              <td><?php echo $row['syozoku_store_id']; ?></td>
              <td><?php if ($row['type_employment'] == 1) {
                    echo '正社員';
                  } elseif ($row['type_employment'] == 2) {
                    echo 'アルバイト';
                  } elseif ($row['type_employment'] == 9) {
                    echo 'その他';
                  } ?></td>
              <td><?php if ($row['role'] == 1) {
                    echo '管理者';
                  } elseif ($row['role'] == 2) {
                    echo '講師';
                  } elseif ($row['role'] == 3) {
                    echo '受付';
                  } elseif ($row['role'] == 9) {
                    echo 'その他';
                  } ?></td>
              <td><?php if ($row['teacher'] == 1) {
                    echo '講師可 ';
                  } elseif ($row['teacher'] == 0) {
                    echo '講師不可';
                  } ?></td>
              <td><?php echo $row['zipcode1'] . $row['zipcode2']; ?></td>
              <td><?php echo $row['prefectures'] . $row['ward'] . $row['address']; ?></td>
              <td><?php echo $row['tel'];  ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['create_date']; ?></td>
              <td><?php echo $row['update_date']; ?></td>
              <td><?php echo $row['delete_date']; ?></td>

              <td>
                <form action="systemuser_update.php" method="post">
                  <input type="submit" title="Update" value="更新" class="button4"></input>
                  <input type="hidden" name="staff_id" value="<?= $row['staff_id'] ?>">
              </td>
              </form>

              <td>
                <form action="systemuser_delete.php" method="post">
                  <input type="submit" title="delete " value="削除 " class="button5"></input>
                  <input type="hidden" name="staff_id" value="<?= $row['staff_id'] ?>">
              </td>
              </form>
            </tr>
          <?php
          }
          ?>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  <br>
  <br>

  <div>
    <a href="<?php echo $href . "systemuser_list.php" ?>">
      <input type="button" class="button" title="delete " value="戻る"></input>
    </a>
  </div>



<?php endif; ?>

<?php

    }
  }
?>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>