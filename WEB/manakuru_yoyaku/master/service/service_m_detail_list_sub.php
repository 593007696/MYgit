<!DOCTYPE HTML>
<html>
<?php date_default_timezone_set('asia/tokyo'); ?>
<!-- タイムゾーンの設定-->

<head>
	<title>サービス詳細一覧</title>
	<meta charset="UTF-8">
	<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../../common/js/edit.js"></script>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/table.css" type="text/css">
	<link rel="stylesheet" href="css/input.css" type="text/css">
	<link rel="stylesheet" href="css/border.css" type="text/css">
	<!--	<link rel="stylesheet" href="css/page.css" type="text/css">
	<link rel="stylesheet" href="css/radio.css" type="text/css">	-->

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
        データベースの接続(PDO) && XSS対策 && clickjacking対策 
			 *************************************************************************************************/
			//データベース接続
			include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/DbManager.php');

			//XSS対策
			function html($str)
			{
				return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
			}

			//clickjacking対策
			header('X-FRAME-OPTIONS: DENY');

?>




<?php
			// POSTで送られてくるパラメータの取得
			$mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING);
			$post_data['no'] = filter_input(INPUT_POST, 'no', FILTER_SANITIZE_STRING);
			$post_data['service_detail_content'] = filter_input(INPUT_POST, 'service_detail_content', FILTER_SANITIZE_STRING);
			$post_data['service_detail_time'] = filter_input(INPUT_POST, 'service_detail_time', FILTER_SANITIZE_STRING);

			$pageFlag = 0;

			if ($mode === 'add' || (isset($_POST['add']))) {

				$pageFlag = 1;
			} elseif ($mode === 'update' || (isset($_POST['update']))) {

				$pageFlag = 2;
			} elseif ($mode === 'delete' || (isset($_POST['delete']))) {

				$pageFlag = 3;
			}

			if (isset($_POST['store_n']) && isset($_POST['service_id'])) {

				$store_n = $_POST['store_n'];
				$service_id = $_POST['service_id'];
			} elseif (isset($_GET['store_n']) && isset($_GET['service_id'])) {

				$store_n = $_GET['store_n'];
				$service_id = $_GET['service_id'];
			}


?>


<?php if ($pageFlag === 0) : ?>

	<body>
		<?php

				try {

					$pdo = GetDb();
					$sql = "SELECT * FROM m_service RIGHT JOIN m_store ON m_service.store_id = m_store.store_id WHERE m_service.service_id=:service_id AND m_service.store_id=:store_id";
					$stmt = $pdo->prepare($sql);
					$stmt->execute(array(':service_id' => $service_id, 'store_id' => $store_n));
					$result = 0;
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
				} catch (PDOException $e) {
					echo 'データベースに接続失敗：' . $e->getMessage();
				}

				// 接続を閉じる
				$pdo = null;

				$store_id_new = $result['store_id'];
				$store_name = $result['store_name'];
				$service_title = $result['service_title'];



		?>

		<div class="center">
			<h2><?= $service_title . "<br>[" . $store_name . "店" . "]" ?></h2>
		</div>


		<?php

				try {
					$pdo = GetDb();

					$sql = "SELECT * FROM m_service_detail WHERE store_id = $store_id_new";		//別店舗の同じサービスのものが出ないよう修正済
					$stmt = $pdo->prepare($sql);
					$stmt->execute();

					//レコード件数
					$row_count = $stmt->rowCount();

					//連想配列で取得
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$rows[] = $row;
					}


					if ($row_count == 0) {

						echo '<br>';
						echo '<FONT COLOR="RED"> 該当するデータはありませんでした </FONT>';
						echo '<br>';
					}
				} catch (PDOException $e) {
					echo 'データベースに接続失敗：' . $e->getMessage();
				}

				// 接続を閉じる
				$pdo = null;

		?>


		<div class="detail">
			<table id="row" class="zebra">
				<thead>
					<tr id="row-title">
						<th class="no">回数</th>
						<th class="service_detail_content">内容</th>
						<th calss="service_detail_time">時間(分)</th>
						<!--	<th>作成日</th>		-->
						<!--	<th>更新日</th>		-->
						<th>編集</th>
						<th>削除</th>
					</tr>
				</thead>

				<?php
				if ($row_count != 0) {
					foreach ($rows as $row) {
						//変数定義
						$store_id = $row['store_id'];
						$service_detail_id = $row['service_id'];
						$no = $row['no'];
						$service_detail_name = $row['service_detail_name'];
						$service_detail_content = $row['service_detail_content'];
						$service_detail_time = $row['service_detail_time'];
						$created_date = $row['created_date'];
						$updated_date = $row['updated_date'];

						if (!empty($service_id) && $service_id == $service_detail_id && $store_id = $store_n) {
				?>
							<tbody>
								<tr class="data-edit">
									<form method="post" action="<?php print basename(__FILE__); ?>">
										<td class="no_value" id="num"><?= $no ?></td>
										<td class="no_change" id="num"><input type="text" id="input" name="service_detail_content" value="<?= $no ?>" readonly></td>
										<td class="content_value"><?= $service_detail_content ?></td>
										<td class="content_change"><input type="text" id="input" name="service_detail_content" value="<?= $service_detail_content ?>"></td>
										<td class="time_value" id="num"><?= $service_detail_time ?></td>
										<td class="time_change" id="num"><input type="text" id="input" name="service_detail_time" value="<?= $service_detail_time ?>"></td>
										<!--	<td class="created"><?= $created_date ?></td>	-->
										<!--	<td class="updated"><?= $updated_date ?></td>	-->
										<td>
											<input type="button" value="編 集" class="edit-line" id="button">
											<input type="submit" value="更 新" class="save-line" id="button2" onclick='return confirm("更新してもよろしいですか？");' />
											<input type="button" value="キャンセル" class="cancel-line" id="button3">
											<input type="hidden" name="no" value="<?= $no ?>">
											<input type="hidden" name="store_id" value="<?= $store_id ?>" class="st">
											<input type="hidden" name="store_name" value="<?= $store_name ?>" class="st">
											<input type="hidden" name="service_id" value="<?= $service_id ?>" class="st">
											<input type="hidden" name="service_detail_name" value="<?= $service_title ?>" class="st">
											<input type="hidden" name="service_title" value="<?= $service_title ?>" class="st">
											<input type="hidden" name="mode" value="update">
									</form>
									</td>

									<td>
										<form method="post" action="<?php print basename(__FILE__); ?>">
											<input type="submit" id="button5" value="削 除" class="delete-line" onclick='return confirm("削除してもよろしいですか？");' />
											<input type="hidden" name="no" value="<?= $no ?>">
											<input type="hidden" name="store_id" value="<?= $store_id ?>" class="st">
											<input type="hidden" name="store_name" value="<?= $store_name ?>" class="st">
											<input type="hidden" name="service_id" value="<?= $service_id ?>" class="st">
											<input type="hidden" name="service_detail_name" value="<?= $service_title ?>" class="st">
											<input type="hidden" name="service_detail_content" value="<?= $service_detail_content ?>" class="st">
											<input type="hidden" name="service_detail_time" value="<?= $service_detail_time ?>" class="st">
											<input type="hidden" name="service_title" value="<?= $service_title ?>" class="st">
											<input type="hidden" name="mode" value="delete">
										</form>
									</td>
								</tr>
							</tbody>
				<?php }
					}
				} ?>
				<tfoot>
					<tr id="add">
						<form method="post" action="<?php print basename(__FILE__); ?>">
							<td class="no"><input type="text" id="input" name="number" pattern="^[0-9]+$" title="半角数字で入力してください" required></td>
							<td class="content"><input type="text" id="input" name="service_detail_content" required></td>
							<td class="times"><input type="text" id="input" name="service_detail_time" pattern="^[0-9]+$" 　title="半角数字で入力してください" 　required></td>
							<!--	<td class="created"></td>	-->
							<!--	<td class="updated"></td>	-->
							<td class="data-edit"><input type="submit" id="button4" value="追 加" onclick='return confirm("追加してもよろしいですか？");' /></td>
							<td></td>
							<input type="hidden" name="store_n" value="<?= $store_n ?>" class="st">
							<input type="hidden" name="store_name" value="<?= $store_name ?>" class="st">
							<input type="hidden" name="service_id" value="<?= $service_id ?>" class="st">
							<input type="hidden" name="service_detail_name" value="<?= $service_title ?>" class="st">
							<input type="hidden" name="mode" value="add">
						</form>
					</tr>
				</tfoot>
			</table>
		</div>
		<input class="button" type="button" onclick="location.href='service_m_list.php'" value="戻る">
	</body>
	<br><br>
	<footer> ©2020 株式会社ジェイテック</footer>

</html>
<?php endif; ?>


<!--追加-->
<?php if ($pageFlag === 1) : ?>
	<?php
				try {

					$store_id = $_POST['store_n'];
					$service_id = $_POST['service_id'];
					$number = html($_POST['number']);
					$service_detail_name = html($_POST['service_detail_name']);
					$service_detail_content = html($_POST['service_detail_content']);
					$service_detail_time = html($_POST['service_detail_time']);
					$created_date = date("Y/m/d H:i:s");

					$pdo = GetDb();

					//回数がサービスマスターのコマ数を超えていないかチェック

					$sql = "SELECT * FROM m_service WHERE store_id = $store_id AND service_id = $service_id";

					$check = $pdo->prepare($sql);

					$check->bindcolumn('frequency', $cnt);

					$check->execute();

					$count = $check->fetch(PDO::FETCH_BOUND);


					if ($number > $cnt) {

						echo "<font color='red'>回数がコマ数より多いです</font>";

						echo "<input type='button' onclick='history.back()' value='戻る'>";
					} else {

						$sql = "INSERT INTO m_service_detail(store_id,service_id,no,service_detail_name,service_detail_content,service_detail_time,created_date) VALUES(:store_id,:service_id,:no,:service_detail_name,:service_detail_content,:service_detail_time,:created_date);";
						$stmt = $pdo->prepare($sql);
						$array = array(':store_id' => $store_id, ':service_id' => $service_id, ':no' => $number, ':service_detail_name' => $service_detail_name, ':service_detail_content' => $service_detail_content, ':service_detail_time' => $service_detail_time, ':created_date' => $created_date);
						$stmt->execute($array);

						$p_store = urldecode($store_id);
						$p_service = urlencode($service_id);

						header("location:service_m_detail_list_sub.php?store_n=$p_store&service_id=$p_service");
						exit;
					}
				} catch (PDOException $e) {
					echo 'データベースに接続失敗：' . $e->getMessage();
				}

				// 接続を閉じる
				$pdo = null;
	?>
<?php endif; ?>




<!--更新-->
<?php if ($pageFlag === 2) : ?>
	<?php
				try {

					$store_id = $_POST['store_id'];
					$service_id = $_POST['service_id'];
					$no = html($_POST['no']);
					$service_detail_name = html($_POST['service_detail_name']);
					$service_detail_content = html($_POST['service_detail_content']);
					$service_detail_time = html($_POST['service_detail_time']);
					$updated_date = date("Y/m/d H:i:s");

					$pdo = GetDb();
					$sql = "UPDATE m_service_detail SET 
						service_detail_content=:service_detail_content,
						service_detail_time=:service_detail_time,
						updated_date=:updated_date
						WHERE no = :no AND store_id = :store_id AND service_id = :service_id AND service_detail_name = :service_detail_name;";

					$stmt = $pdo->prepare($sql);
					$array = array(':store_id' => $store_id, ':service_id' => $service_id, ':no' => $no, ':service_detail_name' => $service_detail_name, ':service_detail_content' => $service_detail_content, ':service_detail_time' => $service_detail_time, ':updated_date' => $updated_date);
					$stmt->execute($array);

					$p_store = urldecode($store_id);
					$p_service = urlencode($service_id);

					header("location:service_m_detail_list_sub.php?store_n=$p_store&service_id=$p_service");
					exit;
				} catch (PDOException $e) {
					echo 'データベースに接続失敗：' . $e->getMessage();
				}

				// 接続を閉じる
				$pdo = null;
	?>
<?php endif; ?>



<!--削除-->
<?php if ($pageFlag === 3) : ?>

	<?php

				try {

					$store_id = $_POST['store_id'];
					$service_id = $_POST['service_id'];
					$no = $_POST['no'];
					$service_detail_name = $_POST['service_detail_name'];
					$service_detail_content = $_POST['service_detail_content'];
					$service_detail_time = $_POST['service_detail_time'];
					$updated_date = date("Y/m/d H:i:s");

					$pdo = GetDb();
					$sql = 'DELETE FROM  m_service_detail  WHERE service_id = :service_id AND store_id =:store_id AND service_detail_name=:service_detail_name AND no=:no';
					$stmt = $pdo->prepare($sql);
					$array = array(':service_id' => $service_id, ':store_id' => $store_id, ":service_detail_name" => $service_detail_name, ":no" => $no);
					$stmt->execute($array);

					$p_store = urldecode($store_id);
					$p_service = urlencode($service_id);

					header("location:service_m_detail_list_sub.php?store_n=$p_store&service_id=$p_service");
					exit;
				} catch (PDOException $e) {
					echo 'データベースに接続失敗：' . $e->getMessage();
				}

				// 接続を閉じる
				$pdo = null;
	?>

<?php endif; ?>


<?php

		}
	}
?>