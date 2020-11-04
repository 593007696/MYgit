<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#btn").trigger("click");
        setTimeout(function() {
            window.close();
        }, 3000);


    });
</script>

<?php
define("weekArr", ["日", "月", "火", "水", "木", "金", "土"]);
$today = date("md");
$hituke = date("m月d日");
$week = date("w");
$youbi = "(" . weekArr[$week] . ")";
$mail = "worktable@jtec-at.co.jp;college@j-tec-cor.co.jp";
$title = "【新卒日報】(張博)" . $today;
$body = <<<body
教育担当の方
%0d%0a
%0d%0a
お疲れ様でした。
%0d%0a
2020年度新卒社員張博です。
%0d%0a
%0d%0a
$hituke $youbi 分の研修日報を送らせていただきます。
%0d%0a
%0d%0a
ご確認宜しくお願い致します
body;



?>



<a href="mailto:<?= $mail ?>?subject=<?= $title ?>&body=<?= $body ?>" target="_top">
    <button id="btn">
        閉じる
    </button>
</a>