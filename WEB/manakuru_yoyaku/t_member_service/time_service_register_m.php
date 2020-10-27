<!DOCTYPE html>

<head>
    <title>予約フォーム</title>

    <!--現在日付を設定する-->
    <script type="text/javascript">
        //今日の日時を表示
        window.onload = function () {
            //今日の日時を表示
            var date = new Date()
            var year = date.getFullYear()
            var month = date.getMonth() + 1
            var day = date.getDate()
          
            var toTwoDigits = function (num, digit) {
              num += ''
              if (num.length < digit) {
                num = '0' + num
              }
              return num
            }
            
            var yyyy = toTwoDigits(year, 4)
            var mm = toTwoDigits(month, 2)
            var dd = toTwoDigits(day, 2)
            var ymd = yyyy + "-" + mm + "-" + dd;
            
            document.getElementById("today1").value = ymd;
        }
    </script>

</head>

<!--ログイン情報-->
<div class=user_information>
<?php
    //ログイン済みの場合
    session_cache_limiter('none');
    session_start();
    
    if ( !isset($_SESSION['STAFF_ID']) && !isset($_SESSION['LAST_NAME']) && !isset($_SESSION['FIRST_NAME']) && !isset( $_SESSION['STORE_ID']) ) {
        echo "ログインしてください。<br /><br />";
        echo '<a href="../login/login.php">ログインへ</a>' ;
   
    }else{
        
        $now = time();
    
        if ($now > $_SESSION['expire']) {
            session_destroy();
            echo "一定時間で操作をしませんでした。ログインし直してください。<a href='../login/login.php'>ログインへ</a>";
        }else{

            include('../common/php/SessionManager.php');
        

    ?>
</div>

<html>


<?php
/*************************************************************************************************
        データベースの接続(PDO)  && clickjacking対策
*************************************************************************************************/
//データベース接続
include('../common/php/DbManager.php');

//clickjacking対策
header('X-FRAME-OPTIONS: DENY');

//timezon設定
date_default_timezone_set('Asia/Tokyo');



/*************************
        画面の遷移
**************************/
$pageFlag = 0;

if(!empty($_POST['confirm'])){
  $pageFlag = 1;
}


if(!empty($_POST['r'])){
    $pageFlag = 2;
  }

?>


<!--------------------------
        各ページ処理
--------------------------->


<?php if($pageFlag === 0) : ?>

    <?php
    $mid=$_POST['member_id'];
    $mn=$_POST['member_name'];

    echo '<p>コワーキングの予約</p>';

    echo '<form action="" method="post">';
    echo '<p>ご利用の店舗：'.$_POST['store_id'];
    echo '<p>ご利用の部屋：'.$_POST['room_id']; ?>
    ?>

    <p>会員ID：<?php echo $mid;?></p>
    <p>会員名：<?php echo $mn;?></p>

    <?php
    echo '<p for="date">日付:';
    
    echo '<input type=date name="start_date" id="today1" required="required">';
    echo ' </br>';
    echo ' </br>';
    echo '<label for="appt-time">予約時刻を選んでください: </label>';
    echo ' </br>';
    echo ' </br>';

    echo '開始時間：';
    $array = array( "9","10", "11", "12", "13", "14" , "15", "16", "17", "18", "19", "20", "21", "22", "23");
    $SelectBox = "<select name=\"h\" required=\"required\">\n";
    for ( $i = 0; $i < count( $array ); $i++ ) {
        $SelectBox .= "\t<option value=\"{$array[$i]}\">{$array[$i]}</option>\n";
    }
    $SelectBox .= "</select>\n";
    echo "{$SelectBox}　時";

    echo '　:　';

    $array = array( "00","10", "20", "30", "40", "50" );
    $SelectBox = "<select name=\"m\" required=\"required\">\n";
    for ( $i = 0; $i < count( $array ); $i++ ) {
        $SelectBox .= "\t<option value=\"{$array[$i]}\">{$array[$i]}</option>\n";
    }
    $SelectBox .= "</select>\n";
    echo "{$SelectBox}　分";
    echo ' </br>';
    echo ' </br>';

    echo '<label for="appt-time">希望の利用時間を選んでください: </label>';
    echo ' </br>';
    echo ' </br>';
    echo '利用時間：';
    $array = array( "1", "2", "3", "4", "5","6","7","8" ,"9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");
    $SelectBox = "<select name=\"hour\" required=\"required\">\n";
    for ( $i = 0; $i < count( $array ); $i++ ) {
        $SelectBox .= "\t<option value=\"{$array[$i]}\">{$array[$i]}</option>\n";
    }
    $SelectBox .= "</select>\n";
    echo "{$SelectBox}　時間";
    echo ' </br>';
    echo ' </br>';
    ?>
    <input type="hidden" name="store_id" value='<?php echo $_POST["store_id"]?>'>
    <input type="hidden" name="room_id" value='<?php echo $_POST["room_id"]?>'>
    <input type="hidden" name="member_id" value='<?php echo $mid?>'>
    <input type="hidden" name="member_name" value='<?php echo $mn?>'>
    <input type="submit" name="confirm" value="確認" >
    <?php

    echo '</form>';
    echo '<form><Input type="button" value="閉じる" onClick="javascript:window.close();"></form>';

?>
<?php endif; ?>


<?php if($pageFlag === 1) : ?>

<?php

    //timezon設定
    date_default_timezone_set('Asia/Tokyo');

    try {

        $pdo = GetDb();

        $sql  = "SELECT * FROM  m_member LEFT JOIN t_member_service_detail using(`member_id`) WHERE member_id = :member_id" ;
        $stmt = $pdo -> prepare($sql);
        $stmt->execute(array(':member_id' => $_POST["member_id"]));
        $result = 0;
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //予約日と予約済日重複しするか
        $sql  = "SELECT * FROM  t_member_service_detail " ;
        $stmt = $pdo -> prepare($sql);
        $stmt->execute();
        //レコード件数
        $row_count = $stmt->rowCount();

        //連想配列で取得
        while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
            $rows[] = $row;
        }
        
        //コワーキングmaster
        $sql  = "SELECT * FROM t_service_set JOIN m_service using(`service_id`) WHERE service_flg='1'" ;
        $stmt = $pdo -> prepare($sql);
        $stmt->execute();
        //レコード件数
        $d_count = $stmt->rowCount();

        //連想配列で取得
        while($d =$stmt->fetch(PDO::FETCH_ASSOC)){
            $ds[] = $d;
        }

    } catch(PDOException $e){
        echo 'データベースに接続失敗：'.$e -> getMessage();
    }
    
    // 接続を閉じる
    $pdo = null;

    echo '<form action="" method="post">';

    //変数定義
    $store_id=$_POST['store_id'];
    $room_id=$_POST['room_id'];
    $member_id=$_POST['member_id'];
    $member_name=$_POST['member_name'];
    $start_date=$_POST['start_date'];
    $start_time=$start_date." ".$_POST['h'].":".$_POST['m'];
    $hour=$_POST['hour'];
    $end_hour=$_POST['h'] + $hour;

    list($yyyy, $mm, $dd) = explode('-', $start_date);
    $yyyy = date('Y', strtotime($start_date)); // 年を取り出す
    $mm = date('m', strtotime($start_date)); //月を取り出す
    $dd = date('d', strtotime($start_date)); // 日を取り出す
    $end_date=$yyyy."-".$mm."-".$dd;
    $end_time =$end_date." ".$end_hour.":".$_POST['m'];
        
    foreach($ds as $d) {
        $service_reserve_flag=$d['service_reserve_flag'];
        $start_day=$d['start_day'];
        $service_start_id=$d['service_start_id'];
        $start_time_base=$d['start_time_base'];
        $end_time_base=$d['end_time_base'];
    }

    if(( $service_reserve_flag=="1")  /**&& ($start_day==$start_date)**/ ){//コワーキングが存在するか確認
    
        echo "<p>予約確認</p>";
        echo ' </br>';
        echo '<p>ご利用の店舗：'.$_POST['store_id'];
        echo '<p>ご利用の部屋：'.$_POST['room_id'];
        echo "<p>会員ID：".$member_id."</p>";
        echo "<p>会員名：".$member_name."　様</p>";
        echo "<p>ご利用の部屋："."</p>";
        echo "<p>利用時間：".$hour."時間</p>";
        

        if($end_hour>=24 ){ //24時を超える予約処理

            // DateTimeクラス インスタンス化
            $d1 = new DateTime($start_date);
            // 1日進める
            $end_date = $d1->modify('+1 days');

            $end_hour=24-$end_hour;

            if($end_hour < 0 ){
                $start_date= new DateTime($start_date);
                $start_time= $start_date->format('Y年m月d日')." ".$_POST['h']."時".$_POST['m']."分";
                $end_time=$end_date->format('Y年m月d日')." ".-$end_hour."時".$_POST['m']."分";
                echo "<p>開始時間：".$start_time."</p>";
                echo "<p>終了時間：". $end_time."</p>";
                $start_time= $start_date->format('Y-m-d')." ".$_POST['h'].":".$_POST['m'];
                $end_time=$end_date->format('Y-m-d')." ".-$end_hour.":".$_POST['m'];
            }else{
                $start_date= new DateTime($start_date);
                $start_time= $start_date->format('Y年m月d日')." ".$_POST['h']."時".$_POST['m']."分";
                $end_time=$end_date->format('Y年m月d日')." ".$end_hour."時".$_POST['m']."分";
                echo "<p>開始時間：".$start_time."</p>";
                echo "<p>終了時間：". $end_time."</p>";
                $start_time= $start_date->format('Y-m-d')." ".$_POST['h'].":".$_POST['m'];
                $end_time=$end_date->format('Y-m-d')." ".$end_hour.":".$_POST['m'];
            }  

            foreach($rows as $row) {         
            //二つの時間帯が重複しないかチェックする
            $startTime1 = strtotime($row['start_time']);
            $endTime1 = strtotime($result['end_time']);
            $startTime2 = strtotime($start_time);
            $endTime2 = strtotime($end_time);           
            }

            if($startTime2 < $endTime1 && $startTime1 < $endTime2 ){
                $end_date= new DateTime( $result['end_time']);
                $end_date->format('Y年m月d日 H時i分');
                echo '--------------------------------'.'<br />';
                echo '<font color="RED"><strong>この時間帯に既に予約が入っています!</strong></font><br />';
                //echo '<font color="RED">お手数をおかけしますが、'.'<font color="RED"><strong>'.$end_date->format('Y年m月d日 H時i分').'</strong></font>'.'　以後のご予約をお願いいたします。</font><br />';
                echo '<br />';
                echo '<form>';
                echo '<input type="button" onclick="history.back()" value="戻る">';
                echo '</form>';


            }else{

                ?>
                <input type="submit" name="r" value="予約" >
                <input type="hidden" name="service_start_id" value="<?php echo $service_start_id; ?>">
                <input type="hidden" name="store_id" value="<?php echo $store_id; ?>">
                <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                <input type="hidden" name="start_time" value="<?php echo $start_time;?>">
                <input type="hidden" name="end_time" value="<?php echo $end_time; ?>">
                <input type="hidden" name="h" value="<?php echo $_POST['h']; ?>" >
                <input type="hidden" name="hour" value="<?php echo $_POST['hour']; ?>" >
                <input type="button" onclick="history.back()" value="戻る">
                </form>
            <?php }
            
        }else{
            
            //24時を超えない予約処理
            $start_date= new DateTime($start_date);
            $start_time=$start_date->format('Y年m月d日')." ".$_POST['h']."時".$_POST['m']."分";
            $end_time=$start_date->format('Y年m月d日')." ".$end_hour."時".$_POST['m']."分";
            echo "<p>開始時間：".$start_time."</p>";
            echo "<p>終了時間：".$end_time."</p>";
            $start_time= $start_date->format('Y-m-d')." ".$_POST['h'].":".$_POST['m'];
            $end_time=$start_date->format('Y-m-d')." ".$end_hour.":".$_POST['m'];
            
            $st=$_POST['h'].":".$_POST['m'];
            $et=$end_hour.":".$_POST['m'];

            foreach($rows as $row) {     
                //二つの時間帯が重複しないかチェックする
                $startTime1 = strtotime($row['start_time']);
                $endTime1 = strtotime($row['end_time']);
                $startTime2 = strtotime($start_time);
                $endTime2 = strtotime($end_time);           
            }

            if($startTime2 < $endTime1 && $startTime1 < $endTime2 ){
                $end_date= new DateTime( $result['end_time']);
                $end_date->format('Y年m月d日 H時i分');
                echo '--------------------------------'.'<br />';
                echo '<font color="RED"><strong>この時間帯に既に予約が入っています!</strong></font><br />';
                //echo '<font color="RED">お手数をおかけしますが、'.'<font color="RED"><strong>'.$end_date->format('Y年m月d日 H時i分').'</strong></font>'.'　以後のご予約をお願いいたします。</font><br />';
                echo '<br />';
                echo '<form>';
                echo '<input type="button" onclick="history.back()" value="戻る">';
                echo '</form>';
                
            }elseif( $st < $start_time_base || $et > $end_time_base){

                $end_date= new DateTime( $result['end_time']);
                $end_date->format('Y年m月d日 H時i分');
                echo '--------------------------------'.'<br />';
                echo '<font color="RED">予約可能の時間帯は、'.'<font color="RED"><strong>'.$start_time_base.'～'.$end_time_base.'</strong></font>'.'です。</font><br />';
                echo '<br />';
                echo '<form>';
                echo '<input type="button" onclick="history.back()" value="戻る">';
                echo '</form>';
            
            }else{

            ?>
                <input type="submit" name="r" value="予約" >
                <input type="hidden" name="service_start_id" value="<?php echo $service_start_id; ?>">
                <input type="hidden" name="store_id" value="<?php echo $store_id; ?>">
                <input type="hidden" name="room_id" value="<?php echo $room_id; ?>">
                <input type="hidden" name="member_id" value="<?php echo $member_id; ?>">
                <input type="hidden" name="start_time" value="<?php echo  $start_time; ?>">
                <input type="hidden" name="end_time" value="<?php echo  $end_time; ?>">
                <input type="hidden" name="h" value="<?php echo $_POST['h']; ?>" >
                <input type="hidden" name="hour" value="<?php echo $_POST['hour']; ?>" >
                <input type="button" onclick="history.back()" value="戻る">
                </form>
                
            <?php }
        }

    }else{
        echo '<font color="RED">大変申し訳ございませんが、ただいま予約が受付出来ません!</font><br />';
        echo '<form>';
        echo '<input type="button" onclick="history.back()" value="戻る">';
        echo '</form>';
    }  
?>
    
<?php endif; ?>


<?php if($pageFlag === 2) : ?>
 
<?php

    //変数定義
    $service_start_id=$_POST['service_start_id'];
    $store_id=$_POST['store_id'];
    $room_id=$_POST['room_id'];
    $member_id=$_POST['member_id'];
    $start_time=$_POST['start_time'];
    $end_time=$_POST['end_time'];
    $created_date  = date("Y/m/d H:i:s");

    //timezon設定
    date_default_timezone_set('Asia/Tokyo');

    $pdo = GetDb();

    $sql = 'INSERT INTO t_member_service_detail   (service_start_id,store_id,member_id,start_time,end_time,created_date) value (:service_start_id,:store_id,:member_id,:start_time,:end_time,:created_date) ';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':service_start_id'=>$service_start_id,':store_id' => $store_id,':member_id' => $member_id,':start_time'=>$start_time,':end_time'=>$end_time,':created_date'=>$created_date));  

    echo "<p>ご予約ありがとうございました</p>";
    echo ' </br>';

    echo '<form><Input type="button" value="閉じる" onClick="javascript:window.close();"></form>';   

?>       
<?php endif; ?>

<?php 
}
   
    }
?>

