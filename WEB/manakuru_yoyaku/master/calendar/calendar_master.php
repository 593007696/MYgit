<?PHP
include('../../common/php/DbManager.php');

?>

<!DOCTYPE html>
<html>

<head>
	<title>カレンダーマスター</title>
	<meta charset="utf-8">

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/table.css" type="text/css">
	<link rel="stylesheet" href="css/input.css" type="text/css">
	<link rel="stylesheet" href="css/border.css" type="text/css">
	<link rel="stylesheet" href="css/page.css" type="text/css">
	<link rel="stylesheet" href="css/radio.css" type="text/css">
	<link rel="stylesheet" href="css/checkbox.css" type="text/css">
	
	<h1><img src="img/logo3.png"></h1>
	
	<script type="text/javascript">
        $(document).ready(function() {
            $('input[name=update]').click(function() {

                if ($("input[type='radio']:checked").length == 0) {
                    if ($("input[type='checkbox']:checked").length < 1) {
                        alert("曜日と営業/休みは必ず選択してください");
                        return false;

                    }
				}
					
				if($("input[type='radio']:checked").length != 0){
					if ($("input[type='checkbox']:checked").length < 1) {
                       alert("曜日は少なくとも一つを選択してください");
                       return false;
					}

				}

				if($("input[type='radio']:checked").length == 0){
					if ($("input[type='checkbox']:checked").length != 0) {
                       alert("営業/休みは必ず選択してください");
                       return false;
					}

				}

                
            });
        });
    </script>

</head>

<!--ログイン情報-->
<?php
    //ログイン済みの場合
    session_cache_limiter('none');
    session_start();

    if (!isset($_SESSION['STAFF_ID']) && !isset($_SESSION['LAST_NAME']) && !isset($_SESSION['FIRST_NAME']) && !isset($_SESSION['STORE_ID'])) {
        echo "ログインしてください。<br /><br />";
        echo '<a href="http://localhost/manakuru_web/manakuru_yoyaku/login/login.php">ログインへ</a>';
    } else {

        $now = time();

        if ($now > $_SESSION['expire']) {
            session_destroy();
            echo "一定時間で操作をしませんでした。ログインし直してください。<a href='../../login/login.php'>ログインへ</a>";
        } else {
           
            
            include('C:xampp/htdocs/manakuru_web/manakuru_yoyaku/common/php/SessionManager.php');


    ?>

<?php
$a="1111";


		if(isset($_POST["store_id"])){

			$store_id = $_POST["store_id"];

		}else{

			$store_id = $_SESSION['STORE_ID'];
		}

		$year = date("Y"); //現在の年を取得
		$month = date("n"); //現在の月を取得
		$day = date("j"); //現在の日を取得

		$nextyear = date("Y", strtotime('+1 year'));	//来年
		$nowyear = "";
		$n_year = "";
		$now_value = "";
		$selected = "";

		//末日を取得関数
		function days_in_month($month, $db_year)

		{
			$year = date("Y"); //現在の年を取得
			//月の日数を計算する
			return $month == 1 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month) % 7 % 2 ? 30 : 31);
		}

		//曜日を返す関数
		function day_of_the_week($db_year, $d_month, $h_day, $w)
		{
			//曜日の配列作成
			$weekday = array("日", "月", "火", "水", "木", "金", "土");
			//各日付の曜日を数値で取得
			$w = date("w", mktime(0, 0, 0, $d_month, $h_day, $db_year));

			//曜日用の配列$weekdayを使い、$weekday[$w]で日本語の曜日を取得する
			return $weekday["$w"];
		}



		if (isset($_POST['update'])) {
			//holiday_flgの値を取得しています。
			if (isset($_POST['holiday_flg'])) {
				(int)$holiday_flg = $_POST['holiday_flg'];
				//echo 'HOLIDAY = '.$holiday_flg.'';
			}
			//配列の中身を文字列に変換
			$weekday = implode($_POST['weekday']);
			$weekval = strval($weekday);
			$selday1 = mb_substr($weekval, 0, 1);
			$selday2 = mb_substr($weekval, 1, 1);
			$selday3 = mb_substr($weekval, 2, 1);
			$selday4 = mb_substr($weekval, 3, 1);
			$selday5 = mb_substr($weekval, 4, 1);
			$selday6 = mb_substr($weekval, 5, 1);
			$selday7 = mb_substr($weekval, 6, 1);
		}

?>


<body>

		<br>
		

	

	<!--データベースにデータあるかないかの確認処理を行っています-->

	<?php

	

		$row = "";

		try {

			$pdo = GetDb();
			$query = "SELECT * FROM m_calendar where store_id = $store_id and year = $year"; 	//今年のカレンダーが存在するか
			$query2 = "SELECT * FROM m_calendar where store_id = $store_id and year = $nextyear";	//来年のカレンダーが存在するか
			$stmt = $pdo->prepare($query);
			$stmh = $pdo->prepare($query2);
			//$stmt->bindparam('store_id',$store_id);
			//$stmt->bindcolumn('year',$d_year);
			$stmt->execute();
			$stmh->execute();
			//$dbval = $stmt;

			while ($val = $stmt->fetch(PDO::FETCH_ASSOC)) {

				$yearval = $val['year'];

				break;
			}

			while ($nval = $stmh->fetch(PDO::FETCH_ASSOC)) {

				$nextval = $nval['year'];

				break;
			}

			if (isset($val['year']) && isset($nval['year'])) {	//当年のデータと来年のデータが両方存在する場合

				$yearval = $val['year'];
				$nextval = $nval['year'];
			} else if (isset($val['year']) && !isset($nval['year'])) {	//当年のデータがあり来年のデータがない場合

				$yearval = $val['year'];
				$nextval = null;
			} else {	//当年と来年のカレンダーが両方存在しない時
				$yearval = null;
				$nextval = null;
			}

			for ($calval = $year; $calval <= $nextyear; $calval++) {	//今年と来年で回す


				//データが存在しない場合、当年のカレンダーを作成

				if ($yearval == null) {
					//年間分の月を取得しています。
					for ($month = 0; $month <= 11; $month++) {
						(int)$d_month = $month + 1;

						//末日を取得
						$lastday = cal_days_in_month(CAL_GREGORIAN, $d_month, $year);

						//月々の日を取得しています。
						for ($day = 1; $day <= $lastday; $day++) {

							//DATE関数で曜日を取得しています。
							$w = date("w", mktime(0, 0, 0, $d_month, $day, $year));

							if($w == 0 || $w == 6){

								$flgval = 1;

							}else{

								$flgval = 0;

							}


							//inset文で一年間分のデータをインプットしています。
							$query = "INSERT INTO m_calendar (store_id,year,month,day,holiday_flg) VALUES ($store_id,$year,$d_month,$day,$flgval)";
							$stmt = $pdo->prepare($query);
							$stmt->execute();
						}

						$yearval = $calval;
					}


					//来年のカレンダーの作成処理を実行

				} else if ($yearval != $nextyear && $nextval == null) {

					for ($month = 0; $month <= 11; $month++) {
						(int)$d_month = $month + 1;

						//末日を取得
						$lastday = cal_days_in_month(CAL_GREGORIAN, $d_month, $nextyear);


						//月々の日を取得しています。
						for ($day = 1; $day <= $lastday; $day++) {

							//DATE関数で曜日を取得しています。
							$w = date("w", mktime(0, 0, 0, $d_month, $day, $nextyear));

							if($w == 0 || $w == 6){

								$flgval = 1;

							}else{

								$flgval = 0;

							}

							//inset文で一年間分のデータをインプットしています。
							$query = "INSERT INTO m_calendar (store_id,year,month,day,holiday_flg) VALUES ($store_id,$nextyear,$d_month,$day,$flgval)";
							$stmt = $pdo->prepare($query);
							$stmt->execute();

							$nextval = $nextyear;
						}
					}
				} //for
			}
		} catch (PDOException $e) {
			echo 'データベースに接続失敗：' . $e->getMessage();
		}
		// 接続を閉じる
		$pdo = null;


	?>
	
	<div class="center">
	<div class="page">

	<?php
	try {
            $pdo = GetDb();

            //店舗セレクトボックス
            $sql = "SELECT * FROM m_store";
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

?>

<!-- 店舗ごとのカレンダー表示-->

	<form method="POST" action="">
        <select id="store_id" name="store_id">";
           
            <?php

				if(isset($_POST['store_id'])){

					$store_id_s = $_POST['store_id'];

				}else{

					$store_id_s = $_SESSION['STORE_ID'];

				};


				if(isset($_POST['store_id']) || isset($_POST['update']) || isset($_GET['sid'])){

					if ($row_count != 0) {
						foreach ($rows as $row) {
							$store_name = $row['store_name'];
							$store_id   = $row['store_id'];
	
							if ($store_id == $store_id_s) {
								echo " <option value=\"" . $store_id . "\" selected>" . $store_name . "</option>\n";
							} else {
								echo " <option value=\"" . $store_id . "\">" . $store_name . "</option>\n";
							}

	
						}
					}

				}else if(empty($_POST['store_id']) && empty($_POST['update']) && empty($_GET['sid'])){	//要条件の検討

                if ($row_count != 0) {
                    foreach ($rows as $row) {
                        $store_name = $row['store_name'];
                        $store_id   = $row['store_id'];

                        if ($store_id == h($_SESSION['STORE_ID'])) {
                            echo " <option value=\"" . $store_id . "\" selected>" . $store_name . "</option>\n";
                        } else {
                            echo " <option value=\"" . $store_id . "\">" . $store_name . "</option>\n";
						}



                    }
				}
				}
            ?>
        </select>

		<?php

		$nowyear = date("Y");
		$month = date("n"); //現在の月を取得
		$day = date("j"); //現在の日を取得
		$s_year = "";


		if(isset($_POST['store_id'])){

			$store_id = $_POST['store_id'];

		}else{

			$store_id = $_SESSION['STORE_ID'];	
		}

		//カレンダーの年検索(条件変更)	

		$pdo = GetDb();
		$sql2 = "SELECT * FROM m_calendar WHERE month = $month AND day = $day AND store_id = $store_id";
		$stmh = $pdo->prepare($sql2);
		$stmh->execute();

		$selyear = $stmh;
//初回

		if(isset($_POST['year'])){	//フラグ更新時

			$s_year = $_POST['year'];

		}

		if(isset($_GET['year'])){		//月単位画面から遷移時

			$s_year = $_GET['year'];

		}



		echo "<select name = 'year'>";

		while ($res = $selyear->fetch(PDO::FETCH_ASSOC)) {

			$nowyear = $res['year'];
			$store_user = $res['store_id'];

			if ($nowyear == $s_year) {

				$selected = 'selected';
			} else {
				$selected = '';
			}



			echo "<option  $selected value = $nowyear>$nowyear</option>";
		}
		echo "</select>";
		echo "<input type='submit' name='s' value='表示切替' id='button2'></input><br>";
		
	


		?>
</form>




		<?php

		if(isset($_POST['store_id'])){		//店舗IDから店舗名取得

			$sid = $_POST['store_id'];

		}else{

			$sid = $_SESSION['STORE_ID'];

		}

		try{

			$pdo = GetDb();

			$sql = "SELECT * FROM m_store WHERE store_id = $sid";

			$result = $pdo->prepare($sql);
			$result->execute();

			$res = $result->fetch(PDO::FETCH_ASSOC);

            $s_name = $res["store_name"];

		}catch (PDOException $e) {
			echo 'データベースに接続失敗：' . $e->getMessage();
		}

		$pdo = null;




	$selectvalue = isset($_POST["year"])? $_POST["year"]:date("Y");

	
	$sid = isset($_POST["store_id"])?$_POST["store_id"]:$_SESSION["STORE_ID"];


		
	?>

	

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<div class="center">
			
				<br>

				<label for="work" class="btn-radio">
					<input type="radio" name="holiday_flg" value="0" id="work">

					<svg width="20px" height="20px" viewBox="0 0 20 20">
						<circle cx="10" cy="10" r="9"></circle>
						<path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
						<path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
					</svg> 
					<span>営業</span>
				</label>

				<label for="holiday" class="btn-radio">
					<input type="radio" name="holiday_flg" value="1" id="holiday">

					<svg width="20px" height="20px" viewBox="0 0 20 20">
						<circle cx="10" cy="10" r="9"></circle>
						<path d="M10,7 C8.34314575,7 7,8.34314575 7,10 C7,11.6568542 8.34314575,13 10,13 C11.6568542,13 13,11.6568542 13,10 C13,8.34314575 11.6568542,7 10,7 Z" class="inner"></path>
						<path d="M10,1 L10,1 L10,1 C14.9705627,1 19,5.02943725 19,10 L19,10 L19,10 C19,14.9705627 14.9705627,19 10,19 L10,19 L10,19 C5.02943725,19 1,14.9705627 1,10 L1,10 L1,10 C1,5.02943725 5.02943725,1 10,1 L10,1 Z" class="outer"></path>
					</svg>
					<span><font color="red">休み</font></span>
				</label>


				<br><br>
				<div class="hang">
					<div class="checkbox"> 

						<input type="checkbox" name="weekday[]" id="week" value="日" class="week"><font color="red">日</font></input>
						<label for="sunday"></label>

					</div>

					<div class="checkbox"> 

						<input type="checkbox" name="weekday[]" id="week" value="月" class="week">月</input>
						<label for="monday"></label>

					</div> 

					<div class="checkbox">

						<input type="checkbox" name="weekday[]" id="week" value="火" class="week">火</input>
						<label for="tuesday"></label>

					</div>

					<div class="checkbox">

						<input type="checkbox" name="weekday[]" id="week" value="水" class="week">水</input>
						<label for="wednesday"></label>

						</div>

						<div class="checkbox"> 

						<input type="checkbox" name="weekday[]" id="week" value="木" class="week">木</input>
						<label for="thursday"></label>

						</div>

						<div class="checkbox">

						<input type="checkbox" name="weekday[]" id="week" value="金" class="week">金</input>
						<label for="fridayday"></label>

						</div>

						<div class="checkbox">

						<input type="checkbox" name="weekday[]" id="week" value="土" class="week"><font color="blue">土</font></input>
						<label for="saturday"></label>

						</div> 
				</div>
				<br><br>
<?php  $aaaa = 11111 ?>
				<input type="hidden" name="store_id" value="<?php echo $store_id?>">
				<input type="hidden" name="year" value="<?php echo $selectvalue ?>">

				<input class="button4" type="submit" name="update" id="update" value="一括更新">
				<input class="button4" type="submit" name="cancel" value="キャンセル">
				<br><br>
			</div>
		</div>
	</form>


	<?php


		if(!empty($_GET['year']) && empty($_POST['year'])){		//月単位画面からの遷移時

			$selectvalue = $_GET['year'];

		}


			$store = $s_name . '店';
			$title = $selectvalue . '年カレンダー';

			echo "<h2>$store</h2>";
			echo "<h2>$title</h2>";
			
?>

	<?php

	if (isset($_POST['update'])) {		//更新時
		
		try {

			$pdo = GetDb();

			//	配列を使用し、曜日を要素順に(日:0〜土:6)を設定しています。
			$week = array("日", "月", "火", "水", "木", "金", "土");

			//データベースに存在しているカレンダーのholiday_flgをUPDATEする処理を行っています。
			$sql = "SELECT * FROM m_calendar WHERE store_id = $store_id";
			$res = $pdo->prepare($sql);

			$res->execute();

			while ($row = $res->fetch(PDO::FETCH_ASSOC)) {		//見つからないのでスルーされる

				//データベースにある年，月，日の変数定数
				$n_year = $row['year'];
				$n_month = $row['month'];
				$n_day = $row['day'];

				//データベースにあるカレンダーの日付の曜日
				$new_week = day_of_the_week($n_year, $n_month, $n_day, $week);

				//チェックボックスに選択された曜日，カレンダーの曜日を一致すればholiday_flgをUPDATEする処理
				if ($new_week == $selday1 || $new_week == $selday2 || $new_week == $selday3 || $new_week == $selday4 || $new_week == $selday5 || $new_week == $selday6 || $new_week == $selday7) {

					//holiday_flgをUPDATEする処理
					$query = "UPDATE m_calendar SET holiday_flg = $holiday_flg WHERE year = $n_year AND month = $n_month AND day = $n_day AND store_id = $sid";
					$stmt = $pdo->prepare($query);

					$stmt->execute();
				}
			}

		echo"<script>";

		echo"alert('更新が完了しました')";
		
		echo"</script>";

		} catch (PDOException $e) {
			echo 'データベースに接続失敗：' . $e->getMessage();
		}

		$pdo = null;
	}

	$_SESSION['sid'] = $sid;

?>
			

<?php

	$lastmonth = 12;
	$max_last = 31;

			echo "<div class='scroll'>";
			echo "<table class='zebra'>";
			echo "<tbody>";

			try {
				$pdo = GetDb();

				//データベースにあるデーターSELECT文で選択して表示しています。
				$sql = "SELECT * FROM m_calendar WHERE year = $selectvalue AND store_id = $sid";
				$res = $pdo->prepare($sql);

				$res->execute();


				//初期化
				$d_month = "";
				$lastdy = "";

				//データベースに存在しているデーターを取得
				while ($dbt = $res->fetch(PDO::FETCH_ASSOC)) {

					//データベースから年,月,日 & holiday_flgを得る変数
					$db_year = $dbt['year'];
					$h_month = $dbt['month'];
					$h_day = $dbt['day'];
					$holiday = $dbt['holiday_flg'];



					$lastday = cal_days_in_month(CAL_GREGORIAN, $h_month, $db_year);


					while ($d_month != $h_month) {

						//h_month=1になった場合"tr"タグを始めています。
						if ($h_month == $h_month) {
							echo '<tr>';
						} else {
						/*	echo '</tr><tr>';	*/
						}

						//Query Stringを使って"月"をリンクしてします。
						echo '<td>' . '<a href=calendar_month_list.php?year=' . $db_year . '&month=' . $h_month . '&sid=' . $sid . '>' . $h_month . '月</a></td>';
						$d_month = $h_month;
					}


					echo "<td>";

					//DATE関数で曜日を取得しています。
					$w = date("w", mktime(0, 0, 0, $d_month, $h_day, $db_year));

					//日付に関する日,曜日を表示しています。
					echo  $h_day . "<br>";

					if($w == 0){

						echo"<font color='red'>";
						echo "(" . day_of_the_week($db_year, $d_month, $h_day, $w) . ")";
						echo"</font>";

					}elseif($w == 6){

						echo"<font color='blue'>";
						echo "(" . day_of_the_week($db_year, $d_month, $h_day, $w) . ")";
						echo"</font>";

					}else{
				
						echo "(" . day_of_the_week($db_year, $d_month, $h_day, $w) . ")";

					}

					//holiday_flg "0"の場合"営業"，"1"の場合"休み"の表示
					if ($holiday == 0) {
						echo "<hr><font color='black'>営</font>";
					} else {
						echo "<hr><font color='red'>休</font>";
					}

					$lastdy = $h_day;

					echo "</td>";

				


					//月末になったら"tr"タグを閉じています。
					if ($h_month == $d_month && $h_day == $lastday) {
						echo '</tr>';

						if($h_month < $lastmonth){
							for($i = 0; $i<=$max_last; $i++){
								echo"<td id='space'>&nbsp;</td>";
							}
						}	
						
					}


				}
				echo "</tbody>";
				echo "</table>";
				echo "</div>";
			} catch (PDOException $e) {
				echo 'データベースに接続失敗：' . $e->getMessage();
			}
			// 接続を閉じる
			$pdo = null;
		

		?>

	</div>
	
	<br>
	<a href="../../menu.php"><input class="button" type="button"  id="back" onclick="reset();" value="戻る"></a>

	<?php

	}
}
	?>
</body>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>
