<!DOCTYPE html>

<head>
    <title>一覧表</title>

    <!-- テーブル -->
    <script  
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
    <script src="../common/js/jquery.tablesorter.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="../common/js/jquery.metadata.js" type="text/javascript" charset="utf-8"></script>
    <script src="../common/js/PaginateMyTable.js" type="text/javascript" charset="utf-8"></script>
    <script src="../common/js/service_search.js"></script>  
    <script type="text/javascript">
    $(document).ready(function(){ 
        $("#myTable").tablesorter();
        $("#myTable").paginate({ 
            rows: 5,         
            position: "bottom",   
            jqueryui: true,   
            showIfLess: false  
        });
    }); 
    </script>

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
            document.getElementById("today2").value = ymd;
        }
    </script>

    <!--日付フォームの値が変更されたら実行-->
    <script>
        $(function () {
            $('input[name="end_date"]').blur(function(){
                $('#show_date').text($(this).val());
            });
        });
    </script>

    <!-- テーマ用CSS -->
    <link rel="stylesheet" href="../common/css/theme.blue.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="../common/css/theme.green.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="../common/css/PaginateMyTable.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="../common/css/style.css" type="text/css">
    
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">

    <!--予約ウインドウ-->
    <script type="text/javascript">
    var w = ( screen.width-640 ) / 2;
    var h = ( screen.height-480 ) / 2;
    function open_r() {
        window.open("about:blank","time_service","width=640,height=480"+ ",left=" + w + ",top=" + h);
        document.time_service.target = "time_service";
        document.time_service.method = "post";
        document.time_service.action = "time_service_register_m.php";
        document.time_service.submit();
    }
    </script>

    <!--予約キャンセルウインドウ-->
    <script type="text/javascript">
    var w = ( screen.width-640 ) / 2;
    var h = ( screen.height-480 ) / 2;
    function open_d() {
        window.open("about:blank","time_service","width=640,height=480"+ ",left=" + w + ",top=" + h);
        document.time_service.target = "time_service";
        document.time_service.method = "post";
        document.time_service.action = "time_service_delete_m.php";
        document.time_service.submit();
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

//新規お申し込み
if(!empty($_POST['application'])){
  $pageFlag = 1;
}

//キャンセル
if(!empty($_POST['cancel'])){
    $pageFlag = 2;
  }


  
?>

<!--------------------------
        各ページ処理
--------------------------->

<?php if($pageFlag === 0) : ?>

<p class="form-title">予約画面</p>  

<?php

if(isset($_SESSION["error"])){
    $error = $_SESSION["error"];
    echo "<ul class='error_list'><li><span >$error</span></li></ul>";
}

unset($_SESSION["error"]);

try {
    $pdo = GetDb();

    $member_id=$_SESSION['member_id'];

    $sql  = "SELECT * FROM   m_member  WHERE member_id = :member_id" ;
    $stmt = $pdo -> prepare($sql);
    $stmt->execute(array(':member_id' =>  $member_id));
    $result = 0;
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //予約マスター
    $sql  = "SELECT t_service_set.store_id,t_service_set.service_start_id, m_service.service_id, m_service.service_name, m_service.service_title, m_service.overview, t_service_set.start_day, t_service_set.end_day,t_service_set.start_time_base,t_service_set.end_time_base,m_service.service_flg FROM t_service_set JOIN m_service using(`service_id`) WHERE yoyaku_flg='1' AND service_reserve_flag='1' AND service_flg='0' " ;
    $stmt = $pdo -> prepare($sql);
    $stmt->execute();
    //レコード件数
    $new_count = $stmt->rowCount();

    //連想配列で取得
    while($new =$stmt->fetch(PDO::FETCH_ASSOC)){
        $news[] = $new;
    }


    //予約履歴
    $sql  = "SELECT m_service.service_id,m_service.service_name,m_service.service_title,t_member_service.service_start_id,t_member_service.store_id,t_member_service.member_id,t_service_set.start_day,t_service_set.end_day,t_service_set.start_time_base,t_service_set.end_time_base,t_service_set.teacher_base,t_service_set.room_id FROM t_member_service JOIN t_service_set using(`service_start_id`) JOIN m_service using(`service_id`)  WHERE member_id = :member_id" ;
    $stmt = $pdo -> prepare($sql);
    $stmt->execute(array(':member_id' =>   $member_id));
    //レコード件数
    $row_count = $stmt->rowCount();

    $rows=[];

    //連想配列で取得
    while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
        $rows[] = $row;
    }


    /**予約可能なリスト**/

    //予約マスター
    $sql  = "SELECT t_service_set.store_id,t_service_set.service_start_id, m_service.service_id, m_service.service_name, m_service.service_title, m_service.overview, t_service_set.start_day, t_service_set.end_day,t_service_set.start_time_base,t_service_set.end_time_base,m_service.service_flg FROM t_service_set JOIN m_service using(`service_id`) WHERE yoyaku_flg='1' AND service_reserve_flag='1' AND service_flg='0' " ;
    $stmt = $pdo -> prepare($sql);
    $stmt->execute();
    $result1 = $stmt->fetchAll();

    $service_start_id_new = array_column($result1, 'service_start_id');
    //var_dump($service_start_id_new);

    //予約履歴
    $sql  = "SELECT m_service.service_id,m_service.service_name,m_service.service_title,t_member_service.service_start_id,t_member_service.store_id,t_member_service.member_id,t_service_set.start_day,t_service_set.end_day,t_service_set.start_time_base,t_service_set.end_time_base,t_service_set.teacher_base,t_service_set.room_id FROM t_member_service JOIN t_service_set using(`service_start_id`) JOIN m_service using(`service_id`)  WHERE member_id = :member_id" ;
    $stmt = $pdo -> prepare($sql);
    $stmt->execute(array(':member_id' =>   $member_id));
    $stmt->execute();
    $result2 = $stmt->fetchAll();

    $service_start_id_row = array_column($result2, 'service_start_id');
    //var_dump($service_start_id_row);

    $result0 = array_diff($service_start_id_new, $service_start_id_row);
    //var_dump($result0);


    $result3=array_intersect_assoc($service_start_id_new, $service_start_id_row);
   
    
    if ($result0) {
        $whereIds = "AND service_start_id IN ('".implode("', '",  $result0)."')";
    }else {
        $whereIds = "";
    }
    
    if(empty($result0)){
        if ($result3) {
            $whereIds = "AND service_start_id  NOT IN ('".implode("', '",  $result3)."')";
        }else {
        $whereIds = "";}
    }
   

    //表示リスト
    $sql  = "SELECT t_service_set.store_id,t_service_set.service_start_id, m_service.service_id, m_service.service_name, m_service.service_title, m_service.overview, t_service_set.start_day, t_service_set.end_day,t_service_set.start_time_base,t_service_set.end_time_base,m_service.service_flg FROM t_service_set JOIN m_service using(`service_id`) WHERE yoyaku_flg='1' AND service_reserve_flag='1' AND service_flg='0' AND 1=1
    {$whereIds} " ;
    $stmt = $pdo -> prepare($sql);
    $stmt->execute();
    //レコード件数
    $list_count = $stmt->rowCount();

    $lists=[];

    //連想配列で取得
    while($list =$stmt->fetch(PDO::FETCH_ASSOC)){
        $lists[] = $list;
    }

    
    //コーアキング予約
    $sql  = "SELECT t_service_set.store_id, t_service_set.room_id,t_service_set.service_start_id, m_service.service_id, m_service.service_name, m_service.service_title, m_service.overview, t_service_set.start_day, t_service_set.end_day,t_service_set.start_time_base,t_service_set.end_time_base,m_service.service_flg FROM t_service_set JOIN m_service using(`service_id`) WHERE yoyaku_flg='1' AND service_reserve_flag='1' AND service_flg='1' " ;
    $stmt = $pdo -> prepare($sql);
    $stmt->execute();
    //レコード件数
    $c_count = $stmt->rowCount();

    //連想配列で取得
    while($c =$stmt->fetch(PDO::FETCH_ASSOC)){
        $cs[] = $c;
    }

} catch(PDOException $e){
    echo 'データベースに接続失敗：'.$e -> getMessage();
    }
    
    // 接続を閉じる
    $pdo = null;
?>

</br>
</br>
<?php echo "受講生："."No.".$result['member_id']." ".$result['last_name'].$result['first_name']."　様";?>
</br>
</br>


</br>
<p>講座の新規予約</p>
</br>
<form method="POST" action="">
    <select id="service_name" name="" >";
        <option value="">全てのコース</option>
        <option value="就職ガイドコース">就職ガイドコース</option>
        <option value="まなクルプログラムコース">まなクルプログラムコース</option>
        <option value="まなクルExcelコース">まなクルExcelコース</option>
        <option value="まなクルWordコース">まなクルWordコース</option>
        <option value="まなクルキッズ英会話コース">まなクルキッズ英会話コース</option>
        <option value="まなクルキッズ音楽コース">まなクルキッズ音楽コース</option>
        <option value="まなクルEnglishコース">まなクルEnglishコース</option>
        <option value="まなクル特別コース">まなクル特別コース</option>
        <option value="その他サービス" >その他</option>
    </select>
    <input type="button" name="s" value="絞り込む" id="button">
</form>

<table id="myTable" class="tablesorter-blue  {sortlist: [[10,0],sortlist: [[11,0]}">
    <thead>
        <tr>
            <th>講座ID</th>
            <th>店舗</th>
            <th>サービス種類</th>
            <th>講座名</th>
            <th>講座タイトル</th>
            <th>内容</th>
            <th>受講期間</th>
            <th>受講お申し込み</th>
        </tr>
    </thead>
<tbody>


<?php if($list_count= !0 )foreach( (array)$lists as $list) {?>
    <?php if(($_SESSION['STORE_ID']==$list['store_id']) ) {?>
    <tr>
    <td><?php echo $list['service_id']; ?></td>
    <td><?php echo $_SESSION['STORE_NAME']; ?></td>
    <td><?php if( $list['service_flg']==0){echo 'サービス単位';}else{echo '時間単位';}?>
    <td><?php echo $list['service_name']; ?></td>
    <td><?php echo $list['service_title']; ?></td>
    <td><?php echo $list['overview']; ?></td>
    <td><?php echo $list['start_day']." ～ ".$list['end_day']; ?></td>
    <td>
        <form action="" method="post">
        <input type="submit" name="application" class="button" title="reservation" value="受講お申し込み"　onclick='return confirm("お申し込みしますか？");'/>
        <input type="hidden" name="service_id" value="<?=$list['service_id']?>">
        <input type="hidden" name="service_start_id" value="<?=$list['service_start_id']?>">
        <input type="hidden" name="store_id" value="<?=$list['store_id']?>">
        <input type="hidden" name="member_id" value="<?= $_SESSION['member_id']?>">
        </form >
    </td>

</tr>
    
<?php
}
}
?>
</tbody>
</table>




</br>
<?php if($c_count!=0){ ?>
<p>コーアキングの新規予約</p>
<table id="myTable1" class="tablesorter-blue  {sortlist: [[10,0],sortlist: [[11,0]}">
    <thead>
        <tr>
            <th>サービスID</th>
            <th>店舗</th>
            <th>サービス種類</th>
            <th>サービス名</th>
            <th>内容</th>
            <th>レンタル可能の日</th>
            <th>レンタル可能の時間帯</th>
            <th>お申し込み</th>
        </tr>
    </thead>
<tbody>

<?php foreach($cs as $c) {?>
    <?php if(($_SESSION['STORE_ID']==$c['store_id']) ) {?>
    <tr>
    <td><?php echo $c['service_id']; ?></td>
    <td><?php echo $_SESSION['STORE_NAME']; ?></td>
    <td><?php if( $c['service_flg']==0){echo 'サービス単位';}else{echo '時間単位';}?>
    <td><?php echo $c['service_name']; ?></td>
    <td><?php echo $c['service_title']; ?></td>
    <td><?php echo $c['start_day']." ～ ".$c['end_day']; ?></td>
    <td><?php echo $c['start_time_base']." ～ ".$c['end_time_base']; ?></td>
    <td>
        <!--<form action="time_service_register.php" method="post">-->
        <form method="post" name="time_service" action="" onsubmit="return false;">
        <input type="submit" name="rental" class="button" title="reservation" value="お申し込み"　 onclick="open_r()"/>
        <input type="submit" name="rental" class="button" title="reservation" value="お申し込み確認"　 onclick="open_d()"/>
        <input type="hidden" name="service_id" value="<?=$c['service_id']?>">
        <input type="hidden" name="service_start_id" value="<?=$c['service_start_id']?>">
        <input type="hidden" name="store_id" value="<?=$c['store_id']?>">
        <input type="hidden" name="member_id" value="<?= $member_id?>">
        <input type="hidden" name="member_name" value="<?=$result['last_name'].$result['first_name']?>">
        <input type="hidden" name="room_id" value="<?=$c['room_id']?>">
        </form >
    </td>
</tr>
    
<?php
}
}
?>
</tbody>
</table>

<?php }?>

</br>

<a href="member_service.php"><input type="button" class="button" title="delete " value="受付画面へ" ></a>
<a href="../member/member_list.php"><input type="button" class="button" title="delete " value="会員一覧表へ" ></a>
</tbody>
</table>


</br>
</br>
</br>


<!--講座の予約履歴-->
<p>お客様予約済み情報</p>
<div class=tb>
<table id="myTable" class="tablesorter-green  {sortlist: [[10,0],sortlist: [[11,0]}">
    <thead>
        <tr>
            <th>講座ID</th>
            <th>講座名</th>
            <th>講座タイトル</th>
            <th>受講期間</th>
            <th>講師</th>
            <th>部屋</th>
            <th>出席</th>
            <th>お申し込みキャンセル</th>
        </tr>
    </thead>

    <tbody>
        <?php if(is_array($rows) ){foreach($rows as $row) {?>
            <?php if(($_SESSION['STORE_ID']==$row['store_id']) ) {?>
            <tr>
            <td><?php echo $row['service_id']; ?></td>
            <td><?php echo $row['service_name']; ?></td>
            <td><?php echo $row['service_title']; ?></td>
            <td><?php echo $row['start_day']." ～ ".$row['end_day']; ?></td>
            <td><?php echo $row['teacher_base']; ?></td>
            <td><?php echo $row['room_id']; ?></td>

            <td>
                <form action="reservation_attend.php" method="post">
                <input type="submit" name="attend" class="button" title="reservation" value="出席"　>
                <input type="hidden" name="service_id_new" value="<?=$row['service_id']?>">
                <input type="hidden" name="service_start_id_new" value="<?=$row['service_start_id']?>">
                <input type="hidden" name="service_name_new" value="<?=$row['service_name']?>">
                <input type="hidden" name="service_title_new" value="<?=$row['service_title']?>">
                <input type="hidden" name="store_id_new" value="<?=$row['store_id']?>">
                <input type="hidden" name="member_id_new" value="<?= $_SESSION['member_id']?>">
                </form >
            </td>

            <td>
                <form action="" method="post">
                <input type="submit" name="cancel" class="button" title="cancel" value="お申し込みキャンセル"　 onclick='return confirm("お申し込みをキャンセルしますか？");'/>                <input type="hidden" name="service_id_new" value="<?=$row['service_name']?>">
                <input type="hidden" name="service_start_id_new" value="<?=$row['service_start_id']?>">
                <input type="hidden" name="service_title_new" value="<?=$row['service_title']?>">
                <input type="hidden" name="store_id_new" value="<?=$row['store_id']?>">
                <input type="hidden" name="member_id_new" value="<?= $_SESSION['member_id']?>">
                </form >
            </td>
        </tr>
            
        <?php
            }
        }
        }
        ?>
    </tbody>
</table>


<?php endif; ?>

<?php if($pageFlag === 1) : ?>

<?php
   try {
        $pdo = GetDb();
    
        //変数定義
    
        $store_id=$_POST['store_id'];
        $service_start_id=$_POST['service_start_id'];
        $member_id=$_POST['member_id'];
        $created_date  = date("Y/m/d H:i:s");
        $error = "既におお申し込みされました。";
    
    
        $sql  = "SELECT * FROM t_member_service WHERE service_start_id=:service_start_id AND store_id=:store_id AND member_id=:member_id" ;
        $stmt = $pdo -> prepare($sql);
        $stmt->execute(array(':service_start_id' => $service_start_id,'store_id'=>$store_id,':member_id'=>$member_id));
        $result1 = 0;
        $result1 = $stmt->fetch(PDO::FETCH_ASSOC);


        $sql  = "SELECT t_service_set.service_start_id,t_service_set.store_id,t_service_set_detail.service_nth_detail,t_service_set_detail.service_nth_detail_sub,t_service_set_detail.start_time_detail,t_service_set_detail.end_time_detail,t_service_set_detail.service_day_detail FROM t_service_set JOIN t_service_set_detail using(`service_start_id`) WHERE t_service_set_detail.service_start_id=:service_start_id" ;
        $stmt = $pdo -> prepare($sql);
        $stmt->execute(array(':service_start_id' => $service_start_id));

        //レコード件数
        $row_count = $stmt->rowCount();

        //連想配列で取得
        while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
            $rows[] = $row;
        }


        if(!empty($result1['service_start_id']) && !empty($result1['store_id']) && !empty($result1['member_id'])){ 
            $stv=$result1['service_start_id'];
            $sid=$result1['store_id'];
            $mid=$result1['member_id'];
       
            if($service_start_id == $stv && $store_id == $sid  && $member_id ==$mid){
        
                $_SESSION["error"] = $error;
                header("location: reservation_detail.php"); 
        
            }

        }else{
            
            $yoyaku_flg=1;
        
            $sql = 'INSERT INTO t_member_service   (store_id,service_start_id,member_id,created_date) value (:store_id,:service_start_id,:member_id,:created_date) ';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':store_id'=>$store_id,':service_start_id'=> $service_start_id,':member_id' => $member_id,':created_date'=>$created_date));  
        
            if($row_count!=0 )foreach ($rows as $row) {

                $service_nth_detail_sub=$row['service_nth_detail_sub'];
                $service_nth_detail=$row['service_nth_detail'];
                $start_time=$row['service_day_detail']." ".$row['start_time_detail'];
                $end_time=$row['service_day_detail']." ".$row['end_time_detail'];

                    
                $sql = 'INSERT INTO t_member_service_detail   (store_id,service_start_id,member_id,service_nth_detail,service_nth_detail_sub,start_time,end_time,yoyaku_flg,created_date) value (:store_id,:service_start_id,:member_id,:service_nth_detail,:service_nth_detail_sub,:start_time,:end_time,:yoyaku_flg,:created_date) ';
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':store_id'=>$store_id,':service_start_id'=> $service_start_id,':member_id' => $member_id,':service_nth_detail_sub'=>$service_nth_detail_sub,':service_nth_detail'=>$service_nth_detail,':start_time'=>$start_time,':end_time'=>$end_time,':yoyaku_flg' => $yoyaku_flg,':created_date'=>$created_date));  

            }else{
                $_SESSION["error"] = $error;
                header("location: reservation_detail.php"); 
            }
            header('location:reservation_detail.php') ;


            }
    
      } catch(PDOException $e){
      echo 'データベースに接続失敗：'.$e -> getMessage();
    }
// 接続を閉じる
$pdo = null;

?>

<?php endif; ?>




<?php if($pageFlag === 2) : ?>
<?php
try {
    $pdo = GetDb();
    $store_id=$_POST['store_id_new'];
    $member_id=$_POST['member_id_new'];
    $service_start_id=$_POST['service_start_id_new'];

    $sql = 'DELETE FROM t_member_service  WHERE  store_id=:store_id AND member_id =:member_id AND service_start_id =:service_start_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':store_id'=>$store_id,':member_id' => $member_id,':service_start_id' => $service_start_id));  

    $sql = 'DELETE FROM  t_member_service_detail  WHERE  member_id =:member_id AND service_start_id =:service_start_id' ;
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':member_id' => $member_id,':service_start_id' => $service_start_id));  
    
    header('location:reservation_detail.php') ;


    } catch(PDOException $e){
echo 'データベースに接続失敗：'.$e -> getMessage();
}

// 接続を閉じる
$pdo = null;

?>

<?php endif; ?>







<style>
.error_list {
    width: 12%;
	padding: 10px 30px;
	color: #ff2e5a;
	font-size: 86%;
	text-align: left;
    border: 1px solid #ff2e5a;
    border-radius: 5px;
}
</style>




<?php 

    }
}
?>