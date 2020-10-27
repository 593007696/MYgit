<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>アップロード</title>
	</head>
	<body>
		<?php
			$fileName=$_FILES["file"]["name"];
			
				if ($_FILES["file"]["error"] > 0)
				{
					echo "<font color=red>エラー:</font> " . $_FILES["file"]["error"] . "<br>";
				}
				else
				{
					echo "アップロードファイル名: " . $fileName . "<br>";
					echo "ファイル属性: " . $_FILES["file"]["type"] . "<br>";
					echo "ファイルサイズ: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
					echo "ファイル一時的な保存場所: " . $_FILES["file"]["tmp_name"] . "<br>";
					
						//  upload ディレクトリの下ファイル存在するか確認
						if (file_exists("upload/" . $fileName))
						{
							echo "<font color=red>".$fileName."</font>". 
							"<font color=red>ファイル既に存在します。</font>";
						}
						else
						{
							//存在しないならアップロード
							move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $fileName);
							echo "ファイル保存場所: " . "upload/" . $fileName;
						}		
				}	
			
		?>
		<br>
		<input type="button" value="戻る" onclick="history.back()">
	</body>
</html>