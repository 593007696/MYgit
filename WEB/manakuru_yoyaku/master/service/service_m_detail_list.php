<!DOCTYPE HTML>
<html>
<?php date_default_timezone_set('asia/tokyo'); ?>
<!-- タイムゾーンの設定を忘れるな-->

<head>
	<title>サービス詳細登録</title>
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

			include('c:/web/git/MANAKURU_WEB/manakuru_yoyaku/common/php/ValidationManager_service_m_detail_list_cfm.php');

			//XSS対策
			function html($str)
			{
				return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
			}

			//clickjacking対策
			header('X-FRAME-OPTIONS: DENY');

?>

<?php
			$pageFlag = 0;
			$error = validation($_POST);

			if (!empty($_POST['add'])  && empty($error)) {
				$pageFlag = 1;
			}

			if (!empty($_POST['update'])) {
				$pageFlag = 2;
			}

			if (!empty($_POST['delete'])) {
				$pageFlag = 3;
			}
?>

<!-- 追加ボタンが空ではなく、且つエラーが空ではなかったら -->
<?php if (!empty($_POST['add']) && !empty($error)) : ?>
	<ul class="error_list">
		<!-- $errorは連想配列なのでforeachで分解していく -->
		<?php foreach ($error as $value) : ?>
			<!-- 分解したエラー文をlistの中に表示していく -->
			<li><?= $value; ?></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<body>
	<?php

			try {

				$service_id = (int)$_GET['service_id'];
				$store_n = (int)$_GET['store_id'];

				//	$_SESSION['STID'] = $store_n;
				//	$_SESSION['SVID'] = $service_id;

				$pdo = GetDb();
				$sql = "SELECT * FROM m_service RIGHT JOIN m_store ON m_service.store_id = m_store.store_id WHERE m_service.service_id =:service_id AND m_service.store_id =:store_id";
				$stmt = $pdo->prepare($sql);
				$stmt->execute(array(':service_id' => $service_id, 'store_id' => $store_n));
				$result = 0;
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				echo 'データベースに接続失敗：' . $e->getMessage();
			}

			// 接続を閉じる
			$pdo = null;

	?>

	<?php

			$store_id_new = $result['store_id'];
			$store_name = $result['store_name'];
			$service_title = $result['service_title'];

	?>
	<br>
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
								<form method="post" action="service_m_detail_list_sub.php">
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
										<input type="submit" name="update" value="更新" class="save-line" id="button2" onclick='return confirm("更新してもよろしいですか？");' />
										<input type="button" value="キャンセル" class="cancel-line" id="button3">
										<input type="hidden" name="no" value="<?= $no ?>">
										<input type="hidden" name="store_id" value="<?= $store_n ?>" class="st">
										<input type="hidden" name="store_name" value="<?= $store_name ?>" class="st">
										<input type="hidden" name="service_id" value="<?= $service_id ?>" class="st">
										<input type="hidden" name="service_detail_name" value="<?= $service_title ?>" class="st">
										<input type="hidden" name="service_title" value="<?= $service_title ?>" class="st">
										<input type="hidden" name="mode" value="update">
								</form>
								</td>

								<td>
									<form method="post" action="service_m_detail_list_sub.php">
										<input type="submit" id="button5" name="delete" value="削 除" class="delete-line" onclick='return confirm("削除してもよろしいですか？");' />
										<input type="hidden" name="no" value="<?= $no ?>">
										<input type="hidden" name="store_id" value="<?= $store_n ?>" class="st">
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
					<form method="post" action="service_m_detail_list_sub.php">
						<td class="no"><input type="text" id="input" name="number" pattern="^[0-9]+$" title="半角数字で入力してください" required></td>
						<td class="content"><input type="text" id="input" name="service_detail_content" required></td>
						<td class="times"><input type="text" id="input" name="service_detail_time" pattern="^[0-9]+$" 　title="半角数字で入力してください" 　required></td>
						<!--	<td class="created"></td>	-->
						<!--	<td class="updated"></td>	-->
						<td class="data-edit"><input type="submit" name="add" id="button4" value="追 加" onclick='return confirm("追加してもよろしいですか？");' /></td>
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
	<br>
	<input class="button" type="button" onclick="location.href='service_m_list.php'" value="戻る">


</body>
<?php

		}
	}
?>
<br><br>
<footer> ©2020 株式会社ジェイテック</footer>

</html>