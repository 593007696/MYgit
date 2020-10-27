<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8">
	<title>サービス　登録/変更　情報確認</title>
	<script type="text/javascript" src="js/security_lock .js"></script>

	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/table.css" type="text/css">
	<link rel="stylesheet" href="css/input.css" type="text/css">
	<link rel="stylesheet" href="css/border.css" type="text/css">
	<link rel="stylesheet" href="css/page.css" type="text/css">
	<link rel="stylesheet" href="css/radio.css" type="text/css">
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
			//POSTセキュリティー
			include("C:\web\git\MANAKURU_WEB\manakuru_yoyaku\common\php\post_security.php");
?>




<body>


	<form action="" method="post">

		<?php

			//クリックジャッキング防止
			header('X-Frame-Options:Deny');

			//データベース接続
			include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');
			$pdo = GetDb();



			//更新OR登録判明
			if (isset($_POST['service_start_id'])) {

				$button = "更新";

				$service_start_id = $_POST['service_start_id'];
				echo '<input 
						type="hidden"
						name="service_start_id"
						value="' . $service_start_id . '">
					';
			} else {

				$button = "登録";

				$service_start_id = "";
			}


			//データPOST
			$store_id = $_POST['store_id'];
			echo '<input type="hidden"name="store_id"value="' . $store_id . '">';

			$service_id = $_POST['service'];
			echo '<input type="hidden"name="service_id"value="' . $service_id . '">';

			$room_id = $_POST['room'];
			echo '<input type="hidden"name="room_id"value="' . $room_id . '">';

			$start_day              = $_POST['start_day'];
			$start_time_base        = $_POST['start_time_base'];
			$end_time_base			= $_POST['end_time_base'];
			$teacher_base           = $_POST['teacher_base'];
			$service_reserve_flag   = $_POST['service_reserve_flag'];
			$note                   = $_POST['note'];
			/********************************************************************* 
				$note    = trim($_POST['note']);  //スペース削除 

				$note    = strip_tags($note);   //htmlタグ削除

				$note    = htmlspecialchars($note);   //正規化  

				$note    = addslashes($note);  //SQL注入対策
			 *****************************************************************************/
			//日、週、月
			$unit = $_POST['unit'];
			echo '<input type="hidden"name="unit"value="' . $unit . '">';
			//間隔数
			$number = $_POST['number'];
			//曜日
			if (isset($_POST['week'])) {

				$week = $_POST['week'];
			} else {
				$number_start_day = strtotime($start_day);
				$number_start_week = date("w", $number_start_day);
				$week = array($number_start_week);
			};



			//項目表示
			$sql =
				"SELECT * FROM `m_service` 
			WHERE `store_id`= :store_id 
			AND`service_id`= :service_id
			";
			$service_date = $pdo->prepare($sql);
			$service_date->bindParam(':service_id', $service_id);
			$service_date->bindParam(':store_id', $store_id);
			$service_date->execute();
			$get_service = $service_date->fetch(PDO::FETCH_ASSOC);

			$service_name	= $get_service['service_name'];
			$service_title	= $get_service['service_title'];
			$frequency		= $get_service['frequency'];
			echo '<input type="hidden"name="frequency"value="' . $frequency . '">';

			echo "
			<div class='center'>
			<h2>サービス $button 情報確認</h2>
			";

			echo "<div class='page'>";
			//サービス名称
			echo    "<br><a>サービス名:</a>
				<a>$service_name-$service_title</a>";
			//部屋名称
			$sql =
				"SELECT * FROM `m_room` 
			WHERE `store_id`= :store_id 
			AND`room_id`= :room_id
			";
			$room_date = $pdo->prepare($sql);
			$room_date->bindParam(':room_id', $room_id);
			$room_date->bindParam(':store_id', $store_id);
			$room_date->execute();
			$get_room = $room_date->fetch(PDO::FETCH_ASSOC);

			$room_name	= $get_room['room_name'];

			echo    "<hr><a>使用する部屋:</a>$room_name";


			//ポストされたデータの最初の曜日の値
			$firstweekval = $week["0"];
			//ポストされた開始日（内部）シリアルナンバーに変換
			$number_start_day = strtotime($start_day);
			//開始日のシリアルナンバーから開始日の曜日（値の形）に変換
			$number_start_week = date("w", $number_start_day);
			//選んだ曜日と開始日（内部）の差計算する（単位はシリアルナンバー）
			$dftime = ($firstweekval - $number_start_week) * 24 * 60 * 60;
			//実際の開始日は開始日（内部）のシリアルナンバー　＋　差
			$rel_start_day = $number_start_day + $dftime;

			//$begin=第一回目の日付

			//開始日（内部）と選んだ曜日のシリアルナンバー一致
			if ($number_start_day == $rel_start_day) {
				$begin = $number_start_day;
			}
			//開始日の後の曜日選んだ
			elseif ($number_start_day < $rel_start_day) {
				$begin = $rel_start_day;
			}
			//開始日の前の曜日選んだ
			elseif ($number_start_day > $rel_start_day) {
				$begin = strtotime("+ 7 days", $rel_start_day);
			}



			//曜日配列
			//$weekArr = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
			$weekArr = array("日", "月", "火", "水", "木", "金", "土");

			//認める週間最大休み
			$max_holiday_cont = 4;
			//日付変更カウント
			$adjust_cont = 0;

			//コマ数で回す
			for ($nth = 0; $nth < $frequency; $nth++) {
				//回間隔計算する
				$interval = ($number + 1) * $unit * $nth;
				//N＋１回目の日付のシリアルナンバー
				$number_nextday = strtotime("+ $interval days", $begin);
				//シリアルナンバーから日付取る

				//回数印刷
				//echo	"第" . ($nth + 1) . "回目：<br>";

				$week_num = count($week);
				echo "<input type='hidden'value=$week_num name='week_num'>";

				if (isset($_POST['week'])) {

					$holiday_cont = 0;
					//ポストされた曜日とそれのに対して日付並べる
					for ($i = 0; $i < $week_num; $i++) {
						//曜日の値配列
						$weekval = $week[$i];
						//値から曜日に変換
						$youbi = $weekArr[$weekval];
						//回数に対しての日付の曜日の値算出
						$nextday_w = date("w", $number_nextday);
						//ポストされたの曜日それぞれの値と毎回の最初の日付の差算出
						$dftime = ($weekval - $nextday_w) * 24 * 60 * 60;
						//ポストされたの曜日の日付シリアルナンバー算出
						$nthday_number = $number_nextday + $dftime;
						//シリアルナンバーから日付変換
						//$nthday = date("Y-m-d", $nthday_number);
						//日付と曜日印刷
						//echo $nthday;
						//echo "(" . $youbi . ")<br>";


						//日付の変更が有れば今回の日付も変更する

						$plus_day = ($adjust_cont * 7);
						$adjust_day_num = strtotime("+ $plus_day days", $nthday_number);
						$nthday = date("Y-m-d", $adjust_day_num);



						//年、月、日獲得
						$m_year = date("Y", strtotime($nthday));
						$m_month = date("m", strtotime($nthday));
						$m_day = date("d", strtotime($nthday));

						//休日かどうか確認する
						$sql =
							"SELECT * 
							FROM `m_calendar` 
							WHERE `store_id` = :store_id
							AND `year` = :m_year
							AND `month` =  :m_month
							AND `day` = :m_day
							";
						$check_holiday = $pdo->prepare($sql);
						$check_holiday->bindParam(':store_id', $store_id);
						$check_holiday->bindParam(':m_year', $m_year);
						$check_holiday->bindParam(':m_month', $m_month);
						$check_holiday->bindParam(':m_day', $m_day);
						$check_holiday->execute();
						$get_holiday_flg = $check_holiday->fetch(PDO::FETCH_ASSOC);


						if (isset($get_holiday_flg['holiday_flg'])) {
							$holiday_flg      = $get_holiday_flg['holiday_flg'];
						} else {
							$holiday_flg = 0;
						};


						if ($holiday_flg == 1) {
							$holiday_cont++;
						};
					};

					if ($holiday_cont < $max_holiday_cont) {

						for ($i = 0; $i < $week_num; $i++) {
							//曜日の値配列
							$weekval = $week[$i];
							//値から曜日に変換
							$youbi = $weekArr[$weekval];
							//回数に対しての日付の曜日の値算出
							$nextday_w = date("w", $number_nextday);
							//ポストされたの曜日それぞれの値と毎回の最初の日付の差算出
							$dftime = ($weekval - $nextday_w) * 24 * 60 * 60;
							//ポストされたの曜日の日付シリアルナンバー算出
							$nthday_number = $number_nextday + $dftime;
							//シリアルナンバーから日付変換
							$nthday = date("Y-m-d", $nthday_number);
							//日付と曜日印刷
							//echo $nthday;
							//echo "(" . $youbi . ")<br>";


							$plus_day = ($adjust_cont * 7);
							$adjust_day_num = strtotime("+ $plus_day days", $nthday_number);
							$nthday = date("Y-m-d", $adjust_day_num);


							//年、月、日獲得
							$m_year = date("Y", strtotime($nthday));
							$m_month = date("m", strtotime($nthday));
							$m_day = date("d", strtotime($nthday));

							//休日かどうか確認する
							$sql =
								"SELECT * 
								FROM `m_calendar` 
								WHERE `store_id` = :store_id
								AND `year` = :m_year
								AND `month` =  :m_month
								AND `day` = :m_day
								";
							$check_holiday = $pdo->prepare($sql);
							$check_holiday->bindParam(':store_id', $store_id);
							$check_holiday->bindParam(':m_year', $m_year);
							$check_holiday->bindParam(':m_month', $m_month);
							$check_holiday->bindParam(':m_day', $m_day);
							$check_holiday->execute();
							$get_holiday_flg = $check_holiday->fetch(PDO::FETCH_ASSOC);

							if (isset($get_holiday_flg['holiday_flg'])) {
								$holiday_flg      = $get_holiday_flg['holiday_flg'];
							} else {
								$holiday_flg = 0;
							};


							if ($week_num == 1) {
								while ($holiday_flg == 1) {

									$adjust_cont++;
									$nthday_num = strtotime($nthday);
									$adjust_day_num = strtotime("+ 7 days", $nthday_num);
									$nthday = date("Y-m-d", $adjust_day_num);

									//年、月、日獲得
									$m_year = date("Y", strtotime($nthday));
									$m_month = date("m", strtotime($nthday));
									$m_day = date("d", strtotime($nthday));

									//休日かどうか確認する
									$sql =
										"SELECT * 
										FROM `m_calendar` 
										WHERE `store_id` = :store_id
										AND `year` = :m_year
										AND `month` =  :m_month
										AND `day` = :m_day
										";
									$check_holiday = $pdo->prepare($sql);
									$check_holiday->bindParam(':store_id', $store_id);
									$check_holiday->bindParam(':m_year', $m_year);
									$check_holiday->bindParam(':m_month', $m_month);
									$check_holiday->bindParam(':m_day', $m_day);
									$check_holiday->execute();
									$get_holiday_flg = $check_holiday->fetch(PDO::FETCH_ASSOC);

									if (isset($get_holiday_flg['holiday_flg'])) {
										$holiday_flg      = $get_holiday_flg['holiday_flg'];
									} else {
										$holiday_flg = 0;
									};
								};
							} else {


								if ($holiday_flg == 1) {
									$nthday = "0000-00-00";
								}
							}
							echo "<input type='hidden'value=$nthday name='nthday[$i][]'>";
							echo "<input type='hidden'value=$youbi name='youbi[$i][]'>";
						}
					} else {

						//while ($holiday_cont >= $max_holiday_cont)

						$adjust_cont++;

						//次の週に振替

						for ($i = 0; $i < $week_num; $i++) {
							//曜日の値配列
							$weekval = $week[$i];
							//値から曜日に変換
							$youbi = $weekArr[$weekval];
							//回数に対しての日付の曜日の値算出
							$nextday_w = date("w", $number_nextday);
							//ポストされたの曜日それぞれの値と毎回の最初の日付の差算出
							$dftime = ($weekval - $nextday_w) * 24 * 60 * 60;
							//ポストされたの曜日の日付シリアルナンバー算出
							$nthday_number = $number_nextday + $dftime + (7 * 24 * 60 * 60);
							//シリアルナンバーから日付変換
							$nthday = date("Y-m-d", $nthday_number);
							//日付と曜日印刷
							//echo $nthday;
							//echo "(" . $youbi . ")<br>";

							//年、月、日獲得
							$m_year = date("Y", strtotime($nthday));
							$m_month = date("m", strtotime($nthday));
							$m_day = date("d", strtotime($nthday));

							//休日かどうか確認する
							$sql =
								"SELECT * 
								FROM `m_calendar` 
								WHERE `store_id` = :store_id
								AND `year` = :m_year
								AND `month` =  :m_month
								AND `day` = :m_day
								";
							$check_holiday = $pdo->prepare($sql);
							$check_holiday->bindParam(':store_id', $store_id);
							$check_holiday->bindParam(':m_year', $m_year);
							$check_holiday->bindParam(':m_month', $m_month);
							$check_holiday->bindParam(':m_day', $m_day);
							$check_holiday->execute();
							$get_holiday_flg = $check_holiday->fetch(PDO::FETCH_ASSOC);

							if (isset($get_holiday_flg['holiday_flg'])) {
								$holiday_flg      = $get_holiday_flg['holiday_flg'];
							} else {
								$holiday_flg = 0;
							};

							if ($week_num == 1) {
								while ($holiday_flg == 1) {

									$adjust_cont++;
									$nthday_num = strtotime($nthday);
									$adjust_day_num = strtotime("+ 7 days", $nthday_num);
									$nthday = date("Y-m-d", $adjust_day_num);

									//年、月、日獲得
									$m_year = date("Y", strtotime($nthday));
									$m_month = date("m", strtotime($nthday));
									$m_day = date("d", strtotime($nthday));

									//休日かどうか確認する
									$sql =
										"SELECT * 
										FROM `m_calendar` 
										WHERE `store_id` = :store_id
										AND `year` = :m_year
										AND `month` =  :m_month
										AND `day` = :m_day
										";
									$check_holiday = $pdo->prepare($sql);
									$check_holiday->bindParam(':store_id', $store_id);
									$check_holiday->bindParam(':m_year', $m_year);
									$check_holiday->bindParam(':m_month', $m_month);
									$check_holiday->bindParam(':m_day', $m_day);
									$check_holiday->execute();
									$get_holiday_flg = $check_holiday->fetch(PDO::FETCH_ASSOC);

									if (isset($get_holiday_flg['holiday_flg'])) {
										$holiday_flg      = $get_holiday_flg['holiday_flg'];
									} else {
										$holiday_flg = 0;
									};
								};
							} else {
								if ($holiday_flg == 1) {
									$nthday = "0000-00-00";
								}
							}
							echo "<input type='hidden'value=$nthday name='nthday[$i][]'>";
							echo "<input type='hidden'value=$youbi name='youbi[$i][]'>";
						};
					};
				} else {


					//日付の変更が有れば今回の日付も変更する
					if ($adjust_cont != 0) {

						$adjust_day_num = strtotime("+ $adjust_cont days", $number_nextday);
						$nthday = date("Y-m-d", $adjust_day_num);
					} else {
						$nthday = date("Y-m-d", $number_nextday);
					};


					//年、月、日獲得
					$m_year = date("Y", strtotime($nthday));
					$m_month = date("m", strtotime($nthday));
					$m_day = date("d", strtotime($nthday));

					//休日かどうか確認する
					$sql =
						"SELECT * 
						FROM `m_calendar` 
						WHERE `store_id` = :store_id
						AND `year` = :m_year
						AND `month` =  :m_month
						AND `day` = :m_day
						";
					$check_holiday = $pdo->prepare($sql);
					$check_holiday->bindParam(':store_id', $store_id);
					$check_holiday->bindParam(':m_year', $m_year);
					$check_holiday->bindParam(':m_month', $m_month);
					$check_holiday->bindParam(':m_day', $m_day);
					$check_holiday->execute();
					$get_holiday_flg = $check_holiday->fetch(PDO::FETCH_ASSOC);

					if (isset($get_holiday_flg['holiday_flg'])) {
						$holiday_flg      = $get_holiday_flg['holiday_flg'];
					} else {
						$holiday_flg = 0;
					};

					//休みではないの日まで回るループ
					while ($holiday_flg == 1) {

						$adjust_cont++;
						$nthday_num = strtotime($nthday);
						$adjust_day_num = strtotime("+ 1 days", $nthday_num);
						$nthday = date("Y-m-d", $adjust_day_num);

						//年、月、日獲得
						$m_year = date("Y", strtotime($nthday));
						$m_month = date("m", strtotime($nthday));
						$m_day = date("d", strtotime($nthday));

						//休日かどうか確認する
						$sql =
							"SELECT * 
							FROM `m_calendar` 
							WHERE `store_id` = :store_id
							AND `year` = :m_year
							AND `month` =  :m_month
							AND `day` = :m_day
							";
						$check_holiday = $pdo->prepare($sql);
						$check_holiday->bindParam(':store_id', $store_id);
						$check_holiday->bindParam(':m_year', $m_year);
						$check_holiday->bindParam(':m_month', $m_month);
						$check_holiday->bindParam(':m_day', $m_day);
						$check_holiday->execute();
						$get_holiday_flg = $check_holiday->fetch(PDO::FETCH_ASSOC);

						if (isset($get_holiday_flg['holiday_flg'])) {
							$holiday_flg      = $get_holiday_flg['holiday_flg'];
						} else {
							$holiday_flg = 0;
						};
					};

					echo "<input type='hidden'value=$nthday name='nthday[]'>";
					//echo 	$nthday . "<br>";
				}
				//echo	"<br>";
			}

			/****************************************************************** 
				//開始日（内部）印刷
				echo	"<br><br>開始日:<br>";
				echo	$start_day . "<br><br>";
			 ********************************************************************/

			echo '<input type="hidden"name="start_day"value="' . $start_day  . '">';


			/***************************************************************** 
				//終了日
				echo "終了日:<br>";
				$end_day = $nthday;
				echo "$end_day<br><br>";
				echo '<input type="hidden"name="end_day"value="' . $end_day  . '">';
			 ***********************************************************************/


			/*******************************************************************************
				//終了日
				echo	"<br><br>終了日:<br>";
				if (isset($_POST['week'])) {
					//$max_gap=第一回目から最終回の間隔日数
					$max_gap = ($number + 1) * $unit * ($frequency - 1);
					//最終回のシリアルナンバー算出
					$endweek_number = strtotime("+ $max_gap days", $begin);

					$max_week = array_search(max($week), $week);
					$endday_weekval = $week[$max_week];
					$endweek_weekval = date("w", $endweek_number);
					$dftime = ($endday_weekval - $endweek_weekval) * 24 * 60 * 60;
					$endday_number = $endweek_number + $dftime;
					//最終回のシリアルナンバーから日付変換
					$endday = date("Y-m-d", $endday_number);

					//最終回の日付印刷
					echo $endday . "<br><br>";
					echo '<input type="hidden"name="endday"value="' . $endday  . '">';
				} else {
					$interval = ($number + 1) * $unit * ($frequency - 1);

					$number_endday = strtotime("+ $interval days", $begin);
					//シリアルナンバーから日付取る
					$endday = date("Y-m-d", $number_endday);
					echo "$endday";
					echo '<input type="hidden"name="endday"value="' . $endday  . '">';
				}
			 ******************************************************************************/


			//開始時間
			echo	"<hr><a>開始時間:</a>";
			$start_time_base_number = strtotime($start_time_base);
			$start_time_base = date("H:i", $start_time_base_number);
			echo	$start_time_base;
			echo	'<input type="hidden" name="start_time_base" value="' . $start_time_base  . '">';

			//終了時間
			echo	"<hr><a>終了時間:</a>";
			//3600は一時間
			//$end_time_base_number = $start_time_base_number + 3600;
			$end_time_base_number = strtotime($end_time_base);
			$end_time_base = date("H:i", $end_time_base_number);
			echo	$end_time_base;
			echo	'<input type="hidden"name="end_time_base"value="' . $end_time_base  . '">';

			//担任講師
			if ($teacher_base != null) {
				$sql =
					"SELECT * FROM `m_systemuser` 
				WHERE`staff_id`= :teacher_base
				";
				$teacher_date = $pdo->prepare($sql);
				$teacher_date->bindParam(':teacher_base', $teacher_base);
				$teacher_date->execute();

				$get_teacher = $teacher_date->fetch(PDO::FETCH_ASSOC);

				$teacher_base_var   =   $get_teacher['last_name'] . $get_teacher['first_name'];
				echo    "<hr><a>担任講師:</a>$teacher_base_var";
			}
			echo    '<input type="hidden"name="teacher_base"value="' . $teacher_base . '">';

			//予約フラグ
			echo	"<hr><a>予約受付状態：</a>";
			echo	'<input type="hidden"name="service_reserve_flag"value="' . $service_reserve_flag  . '">';

			switch ($service_reserve_flag) {
				case "1":
					echo 	"開始<br>";

					break;
				case "0":
					echo 	"<font color=red>未開始</font><br>";

					break;
				default:
			}

			//備考欄
			echo	"<hr><a>備考：</a>";
			echo	'<input type="hidden"name="note"value="' . $note  . '">';
			echo	"<textarea rows='5' cols='40' name='note' id='note'>$note</textarea>";

			//エラーチェック
			$cont_same = 0;
			for ($nth = 0; $nth < $frequency; $nth++) {
				//一回目と二回目の間隔計算する
				$interval = ($number + 1) * $unit * $nth;
				//N＋１回目の日付のシリアルナンバー
				$number_nextday = strtotime("+ $interval days", $begin);
				//回数印刷
				//echo	"第" . ($nth + 1) . "回目：<br>";
				$week_num = count($week);

				if (isset($_POST['week'])) {
					//ポストされた曜日とそれのに対して日付並べる
					for ($i = 0; $i < $week_num; $i++) {
						//曜日の値配列
						$weekval = $week[$i];

						//回数に対しての日付の曜日の値算出
						$nextday_w = date("w", $number_nextday);
						//ポストされたの曜日それぞれの値と毎回の最初の日付の差算出
						$dftime = ($weekval - $nextday_w) * 24 * 60 * 60;
						//ポストされたの曜日の日付シリアルナンバー算出
						$nthday_number = $number_nextday + $dftime;
						//シリアルナンバーから日付変換
						$nthday = date("Y-m-d", $nthday_number);
						//日付と曜日印刷
						//echo $nthday;
						//echo "<br>";
					}
				} else {

					$nthday = date("Y-m-d", $number_nextday);
					//echo 	$nthday . "<br>";
				};


				//時間帯重なるチェック
				if ($button = "更新") {
					$exclude_itself = $service_start_id;
				} else {
					$exclude_itself = "";
				}


				$sql = "SELECT * from t_service_set_detail 
						where service_start_id <> :exclude_itself
						and room_id = :room_id
						and service_day_detail = :nthday
						and store_id =:store_id
						and	start_time_detail <= :end_time_base
						and	end_time_detail >= :start_time_base
						";

				$check_same = $pdo->prepare($sql);
				$check_same->bindParam(':exclude_itself', $exclude_itself);
				$check_same->bindParam(':room_id', $room_id);
				$check_same->bindParam(':nthday', $nthday);
				$check_same->bindParam(':store_id', $store_id);
				$check_same->bindParam(':end_time_base', $end_time_base);
				$check_same->bindParam(':start_time_base', $start_time_base);
				$check_same->execute();

				$same_number = $check_same->rowCount();


				if ($same_number > 0) {

					//回数獲得
					$kaisuu = $nth + 1;

					//重なるデータ獲得
					$get_same		= $check_same->fetch(PDO::FETCH_ASSOC);

					$same_start		= $get_same['start_time_detail'];
					$same_end		= $get_same['end_time_detail'];
					$same_start_id	= $get_same['service_start_id'];
					$same_nth		= $get_same['service_nth'];

					$sql =
						"SELECT * FROM `t_service_set` 
					WHERE `store_id`= :store_id
					AND`service_start_id`= :same_start_id
					";
					$same_service = $pdo->prepare($sql);
					$same_service->bindParam(':store_id', $store_id);
					$same_service->bindParam(':same_start_id', $same_start_id);
					$same_service->execute();
					$get_same_service	= $same_service->fetch(PDO::FETCH_ASSOC);

					$same_service_id	= $get_same_service['service_id'];

					$sql =
						"SELECT * FROM `m_service` 
					WHERE `store_id`	= :store_id
					AND`service_id`		= :same_service_id
					";
					$same_service_name = $pdo->prepare($sql);
					$same_service_name->bindParam(':store_id', $store_id);
					$same_service_name->bindParam(':same_service_id', $same_service_id);
					$same_service_name->execute();
					$get_same_name	= $same_service_name->fetch(PDO::FETCH_ASSOC);

					$same_service_flg   = $get_same_name['service_flg'];

					if ($same_service_flg == 0) {
						$same_name	= $get_same_name['service_name'];
						$same_title	= $get_same_name['service_title'];

						//エラー表示
						echo "<2><font color=red>エラー</font></2>";

						echo "<font color=red>
								$same_name<br>
								$same_title<br>
								第 $same_nth 回目 <br>
								$nthday <br> 
								$same_start~$same_end<br>
								部屋:$room_name<br> 
								使用中の為。
								</font><br><br>";


						echo	"<font>
								$service_name<br>
								$service_title<br>
								第 $kaisuu 回目 <br> 
								$nthday <br> 
								$start_time_base~$end_time_base<br>
								部屋:$room_name<br>
								使用不可です,
								部屋又は時間変更してください。
								</font><br><br>
								";
						$cont_same++;
					};
				} else {
				};
			};
			if ($cont_same != 0) {
				$submit = "hidden";
			} else {
				$submit = "submit";
			};

			echo "</div><br>";
			echo "	
				<input class='button' type='$submit' value='確認' 
				onclick=\"javascript:this.form.action='service_register_result.php';\">
				";

		?>
		<input class="button" type="button" value="戻る" onclick="history.back()">

		</div>
	</form>

<?php

		}
	}
?>
</body>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>