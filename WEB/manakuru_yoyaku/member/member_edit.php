<!DOCTYPE html>
<html>

<head>
  <title>会員情報更新</title>
  <!--<link rel="stylesheet" type="text/css" href="common.css">-->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/form.js"></script>
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="js/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <link rel="stylesheet" href="css/style.css" type="text/css">
  <link rel="stylesheet" href="css/table.css" type="text/css">
  <link rel="stylesheet" href="css/input.css" type="text/css">
  <link rel="stylesheet" href="css/border.css" type="text/css">
  <link rel="stylesheet" href="css/page.css" type="text/css">
  <link rel="stylesheet" href="css/radio.css" type="text/css">
  <link rel="stylesheet" href="css/checkbox.css" type="text/css">
  <link rel="stylesheet" href="css/form.css" type="text/css">
  <link rel="shortcut icon" href="http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/common/img/favicon.ico" />
</head>
<!-- setcookie エラー対策　-->
<?php ob_start(); ?>
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
      date_default_timezone_set('Asia/Tokyo');

      function GetBirthday($init, $now, $cnt)
      {
        for ($i = $init; $i <= $now; $i++) {
          if ($i == intval(trim($cnt))) {
            echo " <option value=\"" . $i . "\" selected>" . $i . "</option>\n";
          } else {
            echo " <option value=\"" . $i . "\">" . $i . "</option>\n";
          }
        }
        return $init;
        return $now;
        return $cnt;
      }
?>


<script type="text/javascript">
  $(function() {
    // 現在の年月日を取得
    var time = new Date();
    var year = time.getFullYear();
    var month = time.getMonth() + 1;
    var date = time.getDate();

    // 選択された年月日を取得
    var selected_year = document.getElementById("year").value;
    var selected_month = document.getElementById("month").value;

    // 年(初期): 1900〜現在の年 の値を設定
    for (var i = year; i >= 1900; i--) {
      $('#year').append('<option value="' + i + '">' + i + '</option>');
    }

    // 月(初期): 1~12 の値を設定
    for (var j = 1; j <= 12; j++) {
      $('#month').append('<option value="' + j + '">' + j + '</option>');
    }

    // 日(初期): 1~31 の値を設定
    for (var k = 1; k <= 31; k++) {
      $('#date').append('<option value="' + k + '">' + k + '</option>');
    }

    // 月(変更)：選択された年に合わせて、適した月の値を選択肢にセットする
    $('#year').change(function() {
      selected_year = $('#year').val();

      // 現在の年が選択された場合、月の選択肢は 1~現在の月 に設定
      // それ以外の場合、1~12 に設定
      var last_month = 12;
      if (selected_year == year) {
        last_month = month;
      }
      $('#month').children('option').remove();
      $('#month').append('<option value="' + 0 + '">--</option>');
      for (var n = 1; n <= last_month; n++) {
        $('#month').append('<option value="' + n + '">' + n + '</option>');
      }
    });

    // 日(変更)：選択された年・月に合わせて、適した日の値を選択肢にセットする
    $('#year,#month').change(function() {
      selected_year = $('#year').val();
      selected_month = $('#month').val();

      // 現在の年・月が選択された場合、日の選択肢は 1~現在の日付 に設定
      // それ以外の場合、各月ごとの最終日を判定し、1~最終日 に設定
      if (selected_year == year && selected_month == month) {
        var last_date = date;
      } else {
        // 2月：日の選択肢は1~28日に設定
        // ※ ただし、閏年の場合は29日に設定
        if (selected_month == 2) {
          if ((Math.floor(selected_year % 4 == 0)) && (Math.floor(selected_year % 100 != 0)) || (Math.floor(selected_year % 400 == 0))) {
            last_date = 29;
          } else {
            last_date = 28;
          }

          // 4, 6, 9, 11月：日の選択肢は1~30日に設定
        } else if (selected_month == 4 || selected_month == 6 || selected_month == 9 || selected_month == 11) {
          last_date = 30;

          // 1, 3, 5, 7, 8, 10, 12月：日の選択肢は1~31日に設定
        } else {
          last_date = 31;
        }
      }

      $('#date').children('option').remove();
      $('#date').append('<option value="' + 0 + '">--</option>');
      for (var m = 1; m <= last_date; m++) {
        $('#date').append('<option value="' + m + '">' + m + '</option>');
      }
    });

  });
</script>


<?php
      $r = filter_input(INPUT_POST, "r");
      if ($r == "更新") {
        try {
          $pdo = GetDb();
          $store_id = $_POST['store_id'];
          $member_id = $_POST['member_id'];
          $last_name = $_POST['last_name'];
          $first_name = $_POST['first_name'];
          $sei = $_POST['sei'];
          $mei = $_POST['mei'];
          $gender = $_POST['gender'];
          $year = $_POST['year'];
          $month = $_POST['month'];
          $date = $_POST['date'];
          $birthday = $year . $month  . $date;
          $age = $_POST['age'];
          $zipcode1 = $_POST['zipcode1'];
          $zipcode2 = $_POST['zipcode2'];
          $prefectures = $_POST['prefectures'];
          $ward = $_POST['ward'];
          $address = $_POST['address'];
          $tel = $_POST['tel'];
          $job = $_POST['job'];
          $email = $_POST['email'];

          $update_date = date("y/m/d H:i:s");

          $query = "UPDATE m_member 
          SET store_id=:store_id,
          last_name=:last_name,
          first_name=:first_name,
          sei=:sei,mei=:mei,
          gender=:gender,
          birthday=:birthday,
          age=:age,
          zipcode1=:zipcode1,
          zipcode2=:zipcode2,
          prefectures=:prefectures,
          ward=:ward,
          address=:address,
          tel=:tel,
          job=:job,
          email=:email,
          update_date=:update_date 
          WHERE member_id=:member_id";

          $stmt = $pdo->prepare($query);

          $array = array(
            ':store_id' => $store_id,
            ':last_name' => $last_name,
            ':first_name' => $first_name,
            ':sei' => $sei,
            ':mei' => $mei,
            ':gender' => $gender,
            ':birthday' => $birthday,
            ':age' => $age,
            ':zipcode1' => $zipcode1,
            ':zipcode2' => $zipcode2,
            ':prefectures' => $prefectures,
            ':ward' => $ward,
            ':address' => $address,
            ':tel' => $tel,
            ':job' => $job,
            ':email' => $email,
            ':update_date' => $update_date,
            ':member_id' => $member_id
          );
          $stmt->execute($array);
          header('location:member_list.php');
        } catch (PDOException $e) {
          echo 'データベースに接続失敗：' . $e->getMessage();
        }

        // 接続を閉じる
        $pdo = null;
      } else {

        try {
          $pdo = GetDb();
          $stmt = $pdo->prepare('SELECT * FROM m_member WHERE member_id = :member_id');
          $stmt->execute(array(':member_id' => $_POST["member_id"]));
          $result = 0;
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
          echo 'データベースに接続失敗：' . $e->getMessage();
        }

        // 接続を閉じる
        $pdo = null;

        $store_id = $result['store_id'];
        $member_id = $result['member_id'];
        $last_name = $result['last_name'];
        $first_name = $result['first_name'];
        $sei = $result['sei'];
        $mei = $result['mei'];
        $gender = $result['gender'];
        $birthday = $result['birthday'];
        $age = $result['age'];
        $zipcode1 = $result['zipcode1'];
        $zipcode2 = $result['zipcode2'];
        $prefectures = $result['prefectures'];
        $ward = $result['ward'];
        $address = $result['address'];
        $tel = $result['tel'];
        $job = $result['job'];
        $email = $result['email'];


        try {
          $pdo = GetDb();
          $sql = "SELECT * FROM m_store ";
          $stmt = $pdo->prepare($sql);
          $stmt->execute();

          $row_count = $stmt->rowCount();
        } catch (PDOException $e) {
          echo 'データベースに接続失敗：' . $e->getMessage();
        }

        $pdo = null;

?>


  <body>
    <div class="center">
      <h2>会員様情報更新</h2>
      <h3>会員ID:<?= $member_id; ?></h3>
    </div>

    <form method="post" action="">

      <div class="form">
        <input type="hidden" name="member_id" value="<?= $member_id; ?>">
        <ul>
          <li>
            <label>店舗:</label>
            <select name="store_id" class="input">
              <option value='0'>店舗を選んでください</option>
              <?php
              if ($row_count != 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  $store_name = $row['store_name'];
                  $tid   = $row['store_id'];
                  if ($tid == $store_id) {

                    $select = "selected";
                  } else {
                    $select = "";
                  }
                  echo '<option ' . $select . ' value= "' . $tid . '">' . $store_name . '</option>';
                }
              }
              ?>
            </select>
          </li>
          <li>
            <label>姓:</label>
            <input type="text" class="input" name="last_name" value="<?= $last_name; ?>" required>
          </li>

          <li>
            <label>名:</label>
            <input type="text" class="input" name="first_name" value="<?= $first_name; ?>" required>
          </li>

          <li>
            <label>セイ:</label>
            <input type="text" class="input" name="sei" value="<?= $sei; ?>" required>
          </li>

          <li>
            <label>メイ:</label>
            <input type="text" class="input" name="mei" value="<?= $mei; ?>" required>
          </li>

          <li>
            <label>性別:</label>
            <label for="male" class="btn-radio">

              <input type="radio" name="gender" value="1" <?php if ($result['gender'] == "1") {
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

              <input type="radio" name="gender" value="2" <?php if ($result['gender'] == "2") {
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

              <input type="radio" name="gender" value="9" <?php if ($result['gender'] == "9") {
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
            list($year, $month, $date) = explode('-', $birthday);
            echo '<select name="year">';
            $now = date("Y");
            GetBirthday(1900, $now, $year);
            echo '</select>年';
            echo '<select name="month">';
            $now = 12;
            GetBirthday(1, $now, $month);
            echo '</select>月';
            echo '<select name="date">';
            $now = 31;
            GetBirthday(1, $now, $date);
            echo '</select>日';
            ?>
          </li>

          <li>
            <label>年齢:</label>
            <input class="input" type=number name="age" value="<?= $age; ?>" required>

          </li>
          <li>
            <label>郵便番号:</label>
            <input type="text" class="input" value="<?= $zipcode1; ?>" name="zipcode1" style="width: 50px;">
            <a>－</a>
            <input type="text" class="input" value="<?= $zipcode2; ?>" name="zipcode2" style="width: 85px;" onKeyUp="AjaxZip3.zip2addr('zipcode1','zipcode2','prefectures','ward','address');">
          </li>
          <li>
            <label>都道府県:</label>
            <input type="text" class="input" name="prefectures" value="<?= $prefectures; ?>">
          </li>
          <li>
            <label>区市町村:</label>
            <input type="text" class="input" name="ward" value="<?= $ward; ?>">
          </li>
          <li>
            <label>住所:</label>
            <input type="text" class="input" name="address" value="<?= $address; ?>">
          </li>

          <li>
            <label>電話番号:</label>
            <input class="input" type="tel" name="tel" value="<?= $tel; ?>" required>
          </li>

          <li>
            <label>職業:</label>

            <label for="student" class="btn-radio">

              <input type="radio" name="job" value="1" <?php if ($result['job'] == "1") {
                                                          echo "checked";
                                                        } ?> id="student" 　required>

              <svg width="20px" height="20px" viewBox="0 0 20 20">
                <circle cx="10" cy="10" r="9"></circle>
                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
              </svg>
              <span>学生</span>
            </label>

            <label for="employee" class="btn-radio">

              <input type="radio" name="job" value="2" <?php if ($result['job'] == "2") {
                                                          echo "checked";
                                                        } ?> id="employee" required>

              <svg width="20px" height="20px" viewBox="0 0 20 20">
                <circle cx="10" cy="10" r="9"></circle>
                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
              </svg>
              <span>会社員</span>
            </label>

            <label for="jobother" class="btn-radio">

              <input type="radio" name="job" value="9" <?php if ($result['job'] == "9") {
                                                          echo "checked";
                                                        } ?> id="jobother" required>

              <svg width="20px" height="20px" viewBox="0 0 20 20">
                <circle cx="10" cy="10" r="9"></circle>
                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
              </svg>
              <span>その他</span>
            </label>
          </li>
          <li>
            <label>メール:</label>
            <input class="input" type="email" name="email" value="<?= $email; ?>" required>
          </li>
        </ul>
      </div>

      <div class="center">
        <input type="submit" class="button" name="r" value="更新" onclick='return confirm("更新しますか？");'>
        <input type="button" class="button" onclick="history.back();" value="戻る">
      </div>

    </form>

  <?php } ?>
<?php

    }
  }
?>
  </body>
  <br><br>
  <footer> ©2020 株式会社ジェイテック</footer>

</html>