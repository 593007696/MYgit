<script>
    //時間可動
    var tokei = setInterval(function() {
        myTime()
    }, 1000);

    //時間表示
    function myTime() {
        var d = new Date();
        var t = d.toLocaleTimeString();
        document.getElementById("time").innerHTML = t;
    }
</script>
<style type="text/css">
    .right {
        position: absolute;
        right: 10px;
        top: 0px;
        padding: 0;
    }

    .left {
        position: absolute;
        left: 10px;
        top: 10px;
        padding: 0;
        font-family: "";
    }
</style>

<div class="right">
    <?php
    $Y = date("Y");
    $M = date("n");
    $D = date("j");
    $W = date("w");
    $WW = array('日', '月', '火', '水', '木', '金', '土');
    echo "<font size='1%'>" . $Y . "-" . $M . "-" . $D . " " . "(" . $WW[$W] . ")</font>";
    ?>
    <br>
    <a id="time" style="font-size: 1%;"></a>
</div>

<div class="left">
    <?php
    function h($s)
    {
        return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
    }

    //ログイン済みの場合
    //echo 'ID:' . h($_SESSION['STAFF_ID']) . "<br>";
    echo h($_SESSION['LAST_NAME']) . " " . h($_SESSION['FIRST_NAME']) . " さん<br>";
    //echo '所属店舗：（' . h($_SESSION['STORE_ID']) . "）" . h($_SESSION['STORE_NAME']) . "店<br>";


    ?>
    <!-- 絶対パス-->
    <a href='http://localhost/git/MANAKURU_WEB/manakuru_yoyaku/login/logout.php'>
        ログアウト
    </a>

</div>
<br><br>