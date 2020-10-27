<!DOCTYPE html>
<html>

<head>
	<title>カレンダー更新(日単位)</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/table.css" type="text/css">
	<link rel="stylesheet" href="css/input.css" type="text/css">
	<link rel="stylesheet" href="css/border.css" type="text/css">
	<link rel="stylesheet" href="css/page.css" type="text/css">
	<link rel="stylesheet" href="css/radio.css" type="text/css">
	<link rel="stylesheet" href="css/checkbox.css" type="text/css">

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

			$select_store = $_SESSION['store_name'];

			include('../../common/php/DbManager.php');

			//タイムゾーンの設定
			date_default_timezone_set('Asia/Tokyo');

			//GETで取った値(年，月，日)
			$year = $_GET['year'];
			$month =  $_GET['month'];
			$day = $_GET['day'];
			$store = $_GET['sid'];

			$timestamp = mktime(0, 0, 0, $month, $day, $year);
			$now_week = date('w', $timestamp);

			$week = array("日", "月", "火", "水", "木", "金", "土");	//曜日

			$now = ($week[$now_week]);


			//カレンダーのタイトルを設定



			$title = date('$year年$n_month月$i');


			//フラグの状態を取得

			try {

				$flg_val = "";

				$pdo = GetDb();

				$sql = "SELECT holiday_flg FROM m_calendar WHERE year = $year AND month = $month AND day = $day AND store_id = $store";

				$stmh = $pdo->prepare($sql);
				$stmh->execute();

				while ($col_val = $stmh->fetch(PDO::FETCH_ASSOC)) {

					$db_flg = $col_val;
				}

				$flg_val = implode($db_flg);
			} catch (PDOException $e) {
				echo $e;
			}

			$pdo = null;

			if ($flg_val == "1") {

				$holi_val = "checked";
				$work_val = "";
			} else {

				$holi_val = "";
				$work_val = "checked";
			}


?>


<body>
	<div class="center">
		<div class="page" id="page">

			<div class="title">
				<?php
				//年，月，日を画面に表示
				echo "<br>";
				echo $select_store	. '店';
				echo "<br>";
				echo $year . '年';
				echo $month . '月';
				echo $day . '日';
				echo '(' . $now . ')';
				//echo"</$select_store店>";
				echo "<br>";
				echo "<br>";

				?>
			</div>

			<form method="post">
				<label for="work" class="btn-radio">
					<input type="radio" <?php echo $work_val ?> name="holiday_flg" value="0" id="work">

					<svg width="20px" height="20px" viewBox="0 0 20 20">
						<circle cx="10" cy="10" r="9"></circle>
						<path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
						<path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
					</svg>
					<span>営業</span>
				</label>

				<label for="holiday" class="btn-radio">
					<input type="radio" <?php echo $holi_val ?> name="holiday_flg" value="1" id="holiday">

					<svg width="20px" height="20px" viewBox="0 0 20 20">
						<circle cx="10" cy="10" r="9"></circle>
						<path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
						<path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
					</svg>
					<span>
						<font color="red">休み</font>
					</span>
				</label>

				<br>
				<br>
		</div>
		<input class="button6" type="submit" name="update" value="更新">
		<a href="calendar_month_list.php?year=<?php echo $year ?>&month=<?php echo $month ?>&sid=<?php echo $store ?>"><button class="button" type="button">戻る</button></a>
		</form>
	</div>

	<?php

			//フラグの取得
			if (isset($_POST['update'])) {
				if (isset($_POST["holiday_flg"])) {

					(int)$holiday_flg = $_POST["holiday_flg"];
				}
			}


			if (isset($_POST['update'])) {

				try {


					$pdo = GetDb();

					$sql = "SELECT * FROM m_calendar";
					$res = $pdo->query($sql);

					$new_week = day_of_the_week($year, $month, $day, $week);

					if ($new_week == $new_week) {
						//holiday_flgをUPDATEする処理
						$query = "UPDATE m_calendar SET holiday_flg = $holiday_flg WHERE year = $year AND month = $month AND day = $day AND store_id = $store";
						$stmt = $pdo->prepare($query);

						$stmt->execute();
					}

					$year_val = urlencode($year);
					$month_val = urlencode($month);

					header("location:calendar_month_list.php?year=$year_val&month=$month_val&sid=$store");
				} catch (PDOException $e) {
				}
			}

	?>

</body>

<br><br>
<?php

		}
	}
?>
<footer class="footer"> ©2020 株式会社ジェイテック</footer>

</html>


<?php
//曜日を返す関数
function day_of_the_week($year, $month, $day, $w)
{
	//曜日の配列作成
	$weekday = array("日", "月", "火", "水", "木", "金", "土");
	//各日付の曜日を数値で取得
	$w = date("w", mktime(0, 0, 0, $month, $day, $year));
	//曜日用の配列$weekdayを使い、$weekday[$w]で日本語の曜日が取得する
	return $weekday["$w"];
}
?>