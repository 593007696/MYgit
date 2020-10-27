<!DOCTYPE html>
<html>

<head>
  <title>会員様登録ページ</title>
  <meta charset="utf-8">

  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="C:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/js/ajaxzip3.js" charset="UTF-8"></script>


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

      //データベース接続
      include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

      //バリデーションファイルをimport
      include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/ValidationManager_member.php');

      //clickjacking対策
      header('X-FRAME-OPTIONS: DENY');



      $pageFlag = 0;

      $error = validation($_POST);

      if (!empty($_POST['confirm']) && empty($error)) {
        $pageFlag = 1;
      }

      if (!empty($_POST['register'])) {
        $pageFlag = 2;
      }

?>

<?php
      $tid = "";
      $last_name = "";
      $first_name = "";
      $sei = "";
      $mei = "";
      $gender = "";
      $year = "";
      $month = "";
      $date = "";
      $birthday = "";
      $age = "";
      $zipcode1 = "";
      $zipcode2 = "";
      $prefectures = "";
      $ward = "";
      $address = "";
      $tel = "";
      $job = "";
      $email = "";

      if (!empty($_POST['confirm']) && !empty($error)) :
?>
  <ul class="error">

    <?php foreach ($error as $value) : ?>
      <li><?php echo $value; ?></li>
    <?php endforeach; ?>

  </ul>

<?php
        $tid = $_POST['store_id'];
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $sei = $_POST['sei'];
        $mei = $_POST['mei'];
        $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
        $year = $_POST['year'];
        $month = $_POST['month'];
        $date = $_POST['date'];
        $birthday = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['date'];
        $age = $_POST['age'];
        $zipcode1 = $_POST['zipcode1'];
        $zipcode2 = $_POST['zipcode2'];
        $prefectures = $_POST['prefectures'];
        $ward = $_POST['ward'];
        $address = $_POST['address'];
        $tel = $_POST['tel'];
        $job = isset($_POST["job"]) ? $_POST['job'] : "";
        $email = $_POST['email'];
      endif;
?>

<?php
      try {
        $pdo = GetDb();
        $sql = "SELECT * FROM m_store ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $row_count = $stmt->rowCount();

        if ($row_count != 0) {
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
          }
        }
      } catch (PDOException $e) {
        echo 'データベースに接続失敗：' . $e->getMessage();
      }

      $pdo = null;

?>


<body>
  <?php if ($pageFlag === 0) : ?>


    <!-- 入力画面 -->
    <div class="center">
      <h2>会員様登録</h2>
    </div>


    <form method="post" action="">

      <div class="form">
        <ul>
          <li>
            <label>店舗</label>
            <select name="store_id" class="input">
              <option value='0'>店舗を選んでください</option>
              <?php
              if ($row_count != 0) {
                foreach ($rows as $row) {
                  $store_name = $row['store_name'];
                  $store_id   = $row['store_id'];
                  $selected  = $tid == $store_id ? "selected" : "";
                  echo " <option " . $selected . " value='" . $store_id . "'>" . $store_name . "</option>";
                }
              }
              ?>
            </select>
          </li>


          <li><label>姓</label>
            <input type="text" class="input" name="last_name" placeholder="例:田中" value="<?= $last_name ?>">
          </li>


          <li><label>名</label>
            <input type="text" class="input" name="first_name" placeholder="例:太郎" value="<?= $first_name ?>">
          </li>


          <li><label>セイ</label>
            <input type="text" class="input" name="sei" placeholder="例:タナカ" value="<?= $sei ?>">
          </li>


          <li><label>メイ</label>
            <input type="text" class="input" name="mei" placeholder="例:タロウ" value="<?= $mei ?>">
          </li>


          <li><label>性別</label>

            <label for="male" class="btn-radio">

              <input type="radio" name="gender" value="1" id="male" <?php echo $gender == "1" ? "checked" : ""; ?>>

              <svg width="20px" height="20px" viewBox="0 0 20 20">
                <circle cx="10" cy="10" r="9"></circle>
                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
              </svg>
              <span>男</span>
            </label>

            <label for="female" class="btn-radio">

              <input type="radio" name="gender" value="2" id="female" <?php echo $gender == "2" ? "checked" : ""; ?>>

              <svg width="20px" height="20px" viewBox="0 0 20 20">
                <circle cx="10" cy="10" r="9"></circle>
                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
              </svg>
              <span>女</span>
            </label>

            <label for="other" class="btn-radio">

              <input type="radio" name="gender" value="9" id="other" <?php echo $gender == "9" ? "checked" : ""; ?>>

              <svg width="20px" height="20px" viewBox="0 0 20 20">
                <circle cx="10" cy="10" r="9"></circle>
                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
              </svg>
              <span>その他</span>
            </label>
          </li>


          <li><label>生年月日</label>
            <select id="year" name="year" class="input" style="width: 60px;">
              <option value="0">--年</option>
            </select>
            <select id="month" name="month" class="input" style="width: 45px;">
              <option value="0">-月</option>
            </select>
            <select id="date" name="date" class="input" style="width: 45px;">
              <option value="0">-日</option>
            </select>
          </li>



          <li><label>年齢</label>
            <input type="text" class="input" id="age" name="age" readonly="readonly" placeholder="ここは入力できません">
          </li>


          <li><label>郵便番号</label>
            <input type="text" class="input" name="zipcode1" style="width: 50px;" placeholder="上三位" value="<?= $zipcode1 ?>">
            <a>－ </a>
            <input type="text" class="input" name="zipcode2" style="width: 85px;" placeholder="下四位" value="<?= $zipcode2 ?>" onKeyUp="AjaxZip3.zip2addr('zipcode1','zipcode2','prefectures','ward','address');">
          </li>

          <li><label>都道府県</label>
            <input type="text" class="input" name="prefectures" placeholder="例:東京都" value="<?= $prefectures ?>">
          </li>

          <li><label>区市町村</label>
            <input type="text" class="input" name="ward" placeholder="例：○○区" value="<?= $ward ?>">
          </li>

          <li><label>住所</label>
            <input type="text" class="input" name="address" placeholder="例：○○-○○丁目-○○番-○○○" value="<?= $address ?>">
          </li>



          <li><label>電話番号</label>
            <input class="input" type="tel" name="tel" placeholder="-なし10～11桁の半角数字" value="<?= $tel ?>">
          </li>



          <li><label>職業</label>

            <label for="student" class="btn-radio">

              <input type="radio" name="job" value="1" id="student" <?php echo $job == "1" ? "checked" : "" ?>>

              <svg width="20px" height="20px" viewBox="0 0 20 20">
                <circle cx="10" cy="10" r="9"></circle>
                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
              </svg>
              <span>学生</span>
            </label>

            <label for="employee" class="btn-radio">

              <input type="radio" name="job" value="2" id="employee" <?php echo $job == "2" ? "checked" : "" ?>>

              <svg width="20px" height="20px" viewBox="0 0 20 20">
                <circle cx="10" cy="10" r="9"></circle>
                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
              </svg>
              <span>会社員</span>
            </label>

            <label for="jobother" class="btn-radio">

              <input type="radio" name="job" value="9" id="jobother" <?php echo $job == "9" ? "checked" : "" ?>>

              <svg width="20px" height="20px" viewBox="0 0 20 20">
                <circle cx="10" cy="10" r="9"></circle>
                <path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
                <path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
              </svg>
              <span>その他</span>
            </label>
          </li>




          <li><label>メール</label>
            <input class="input" type="email" name="email" placeholder="例：aaa@a.com" value="<?= $email ?>">
          </li>


          <li><label>パスワード</label>
            <input class="input" type="password" name="password1" placeholder="英数字混ぜて8位以上">
          </li>


          <li><label>確認パスワード</label>
            <input class="input" type="password" name="password2" placeholder="もう一度入力">
          </li>

        </ul>
      </div>

      <div class="center">
        <input type="submit" class="button" name="confirm" value="確認">
        <a href="member_list.php">
          <input type="button" class="button" value="戻る">
        </a>
      </div>

    </form>

    <script>
      $(document).ready(function() {

        $("#year").change(function() {
          var value = $("#year").val();
          var birthday = new Date(value);
          var today = new Date();
          var age = Math.floor((today - birthday) / (365.25 * 24 * 60 * 60 * 1000));
          if (isNaN(age)) {

            // will set 0 when value will be NaN
            age = 0;

          } else {
            age = age;
          }
          $('#age').val(age);

        });

      });

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

        // 月(変更):選択された年に合わせて、適した月の値を選択肢にセットする
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

        // 日(変更):選択された年・月に合わせて、適した日の値を選択肢にセットする
        $('#year,#month').change(function() {
          selected_year = $('#year').val();
          selected_month = $('#month').val();

          // 現在の年・月が選択された場合、日の選択肢は 1~現在の日付 に設定
          // それ以外の場合、各月ごとの最終日を判定し、1~最終日 に設定
          if (selected_year == year && selected_month == month) {
            var last_date = date;
          } else {
            // 2月:日の選択肢は1~28日に設定
            // ※ ただし、閏年の場合は29日に設定
            if (selected_month == 2) {
              if ((Math.floor(selected_year % 4 == 0)) && (Math.floor(selected_year % 100 != 0)) || (Math.floor(selected_year % 400 == 0))) {
                last_date = 29;
              } else {
                last_date = 28;
              }

              // 4, 6, 9, 11月:日の選択肢は1~30日に設定
            } else if (selected_month == 4 || selected_month == 6 || selected_month == 9 || selected_month == 11) {
              last_date = 30;

              // 1, 3, 5, 7, 8, 10, 12月:日の選択肢は1~31日に設定
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

  <?php endif; ?>

  <?php if ($pageFlag === 1) : ?>
    <!-- 確認画面 -->
    <div class="center">
      <h2>確認画面</h2>

      <h4>以下の情報確認の上に登録ボタン押してください</h4>

      <div class="page">

        <?php
        $store_id = $_POST['store_id'];
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $sei = $_POST['sei'];
        $mei = $_POST['mei'];
        $gender = $_POST['gender'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        $date = $_POST['date'];
        $birthday = $_POST['year'] . '-' . $_POST['month'] . '-' . $_POST['date'];
        $age = $_POST['age'];
        $zipcode1 = $_POST['zipcode1'];
        $zipcode2 = $_POST['zipcode2'];
        $prefectures = $_POST['prefectures'];
        $ward = $_POST['ward'];
        $address = $_POST['address'];
        $tel = $_POST['tel'];
        $job = $_POST['job'];
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        $sql = "SELECT `member_id` 
        FROM `m_member`
        WHERE `create_date`= 
        (SELECT MAX(`create_date`) 
        FROM `m_member`
        WHERE `store_id`= :store_id)";

        $pdo = GetDb();
        $maxid = $pdo->prepare($sql);
        $maxid->bindParam(':store_id', $store_id);
        $maxid->execute();
        $member_count = $maxid->rowCount();
        if ($member_count > 0) :
          $get_max_id = $maxid->fetch(PDO::FETCH_NUM);

          $id_num = substr($get_max_id[0], 3) + 1;

          $bit = 6;
          $num_len = strlen($id_num);
          $zero = "";
          for ($i = $num_len; $i < $bit; $i++) {
            $zero .= "0";
          }

          $member_id = $store_id . "-" . $zero . $id_num;
        else : $member_id = $store_id . "-" . "000001";
        endif;

        echo "<br>会員ID:　$member_id";
        echo "<hr><br>";

        echo "名前(漢字):　$last_name $first_name";
        echo "<hr><br>";

        echo "名前(カタカナ):　$sei $mei";
        echo "<hr><br>";

        echo "性別:";
        if ($gender == 1) {
          echo '男性';
        } elseif ($gender == 2) {
          echo '女性';
        } elseif ($gender == 9) {
          echo 'その他';
        };
        echo "<hr><br>";

        echo "誕生日:　$birthday";
        echo "<hr><br>";

        echo "年齢:　$age";
        echo "<hr><br>";

        echo "郵便番号:　$zipcode1-$zipcode2";
        echo "<hr><br>";

        echo "都道府県:　$prefectures";
        echo "<hr><br>";

        echo "区市町村:　$ward";
        echo "<hr><br>";

        echo "住所:　$address";
        echo "<hr><br>";

        echo "電話番号:　$tel";
        echo "<hr><br>";

        echo "職業:　$job";
        echo "<hr><br>";

        echo "メール:　$email";
        echo "<hr><br>";


        echo "パスワード:　$password1 <br><br>";



        echo '<form method="post" action="">';
        echo '<input type="hidden" name="member_id" value="' . $member_id . '">';
        echo '<input type="hidden" name="store_id" value="' . $store_id . '">';
        echo '<input type="hidden" name="last_name" value="' . $last_name . '">';
        echo '<input type="hidden" name="first_name" value="' . $first_name . '">';
        echo '<input type="hidden" name="sei" value="' . $sei . '">';
        echo '<input type="hidden" name="mei" value="' . $mei . '">';
        echo '<input type="hidden" name="gender" value="' . $gender . '">';
        echo '<input type="hidden" name="birthday" value="' . $birthday . '">';
        echo '<input type="hidden"name="age"value="' . $age . '">';
        echo '<input type="hidden"name="zipcode1"value="' . $zipcode1 . '">';
        echo '<input type="hidden"name="zipcode2"value="' . $zipcode2 . '">';
        echo '<input type="hidden"name="prefectures"value="' . $prefectures . '">';
        echo '<input type="hidden"name="ward"value="' . $ward . '">';
        echo '<input type="hidden"name="address"value="' . $address . '">';
        echo '<input type="hidden"name="tel"value="' . $tel . '">';
        echo '<input type="hidden" name="job" value="' . $job . '">';
        echo '<input type="hidden"name="email"value="' . $email . '">';
        echo '<input type="hidden"name="password1"value="' . $password1 . '">';
        ?>
      </div>


      <input class="button" type="submit" name="register" value="登録" onclick="return confirm('登録しますか？');">

      <input class="button" type="button" onclick="history.back();" value="戻る">
      </form>

    </div>
  <?php endif; ?>


  <?php if ($pageFlag === 2) : ?>
    <!-- 完了画面 -->

    <?php
        try {
          $pdo = GetDb();

          date_default_timezone_set('Asia/Tokyo');
          $member_id = $_POST["member_id"];
          $store_id = $_POST['store_id'];
          $last_name = $_POST['last_name'];
          $first_name = $_POST['first_name'];
          $sei = $_POST['sei'];
          $mei = $_POST['mei'];
          $gender = $_POST['gender'];
          $birthday = $_POST['birthday'];
          $age = $_POST['age'];
          $zipcode1 = $_POST['zipcode1'];
          $zipcode2 = $_POST['zipcode2'];
          $prefectures = $_POST['prefectures'];
          $ward = $_POST['ward'];
          $address = $_POST['address'];
          $tel = $_POST['tel'];
          $job = $_POST['job'];
          $email = $_POST['email'];
          $hash_pass = password_hash($_POST['password1'], PASSWORD_DEFAULT); //パスワードの暗号化
          $create_date = date("y/m/d H:i:s");

          $query = "INSERT 
          INTO m_member(member_id,
          store_id,
          last_name,
          first_name,
          sei,
          mei,
          gender,
          birthday,
          age,
          zipcode1,
          zipcode2,
          prefectures,
          ward,
          address,
          tel,
          job,
          email,
          password,
          create_date) 
          VALUES 
          (:member_id,
          :store_id,
          :last_name,
          :first_name,
          :sei,
          :mei,
          :gender,
          :birthday,
          :age,
          :zipcode1,
          :zipcode2,
          :prefectures,
          :ward,
          :address,
          :tel,
          :job,
          :email,
          :password,
          :create_date)";
          $stmt = $pdo->prepare($query);
          $stmt->bindparam(":member_id", $member_id);
          $stmt->bindparam(":store_id", $store_id);
          $stmt->bindparam(":last_name", $last_name);
          $stmt->bindparam(":first_name", $first_name);
          $stmt->bindparam(":sei", $sei);
          $stmt->bindparam(":mei", $mei);
          $stmt->bindParam(':gender', $gender);
          $stmt->bindParam(':birthday', $birthday);
          $stmt->bindParam(':age', $age);
          $stmt->bindParam(':zipcode1', $zipcode1);
          $stmt->bindParam(':zipcode2', $zipcode2);
          $stmt->bindParam(':prefectures', $prefectures);
          $stmt->bindParam(':ward', $ward);
          $stmt->bindParam(':address', $address);
          $stmt->bindParam(':tel', $tel);
          $stmt->bindParam(':job', $job);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':password', $hash_pass);
          $stmt->bindParam(':create_date', $create_date);

          $stmt->execute();

          header('location:member_list.php');
        } catch (PDOException $e) {
          echo 'データベースに接続失敗:' . $e->getMessage();
        }

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