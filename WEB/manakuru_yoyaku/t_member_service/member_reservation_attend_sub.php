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
    <link rel="stylesheet" href="../common/css/PaginateMyTable.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="../common/css/style.css" type="text/css">
    
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">

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

//新規申し込み
if(!empty($_POST['confirm'])){
  $pageFlag = 1;
}

//キャンセル
if(!empty($_POST['cancel'])){
    $pageFlag = 2;
  }


?>



<?php if($pageFlag ===0): ?>


<?php
    try {
    $pdo = GetDb();

    $store_id=$_SESSION['store_id_new'];
    $service_id=$_SESSION['service_id_new'];
    $service_start_id=$_SESSION['service_start_id_new'];
    $start_time=$_SESSION['start_time_new'];
    $end_time=$_SESSION['end_time_new'];



    $sql  = "SELECT t_member_service_detail.store_id,t_member_service_detail.attend_flg,t_service_set.service_id,t_member_service_detail.service_start_id,t_member_service_detail.service_nth_detail,t_member_service_detail.service_nth_detail_sub,t_member_service_detail.member_id,m_member.last_name,m_member.first_name,t_member_service_detail.start_time,t_member_service_detail.end_time,m_service.service_name,m_service.service_title FROM m_member JOIN t_member_service_detail using(member_id) JOIN t_service_set using(service_start_id) JOIN m_service using(service_id) WHERE t_member_service_detail.service_start_id=:service_start_id AND t_member_service_detail.store_id=:store_id AND t_service_set.service_id =:service_id AND start_time=:start_time AND end_time=:end_time" ;
    $stmt = $pdo -> prepare($sql);
    $stmt->execute(array(':store_id' =>  $store_id,':service_id' =>  $service_id,':service_start_id' =>  $service_start_id,':start_time'=>$start_time,':end_time' => $end_time));

    //レコード件数
    $row_count = $stmt->rowCount();

    //連想配列で取得
    while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
        $rows[] = $row;
    }
    

} catch(PDOException $e){
    echo 'データベースに接続失敗：'.$e -> getMessage();
    }
    // 接続を閉じる
    $pdo = null;
    
?>



<p class="form-title">出席確認</p>

<form method="post" action="">
    <div class=tb>
    <table id="myTable" class="tablesorter-blue  {sortlist: [[3,0],sortlist: [[4,0]},sortlist: [[5,0]}">

    <thead>
        <tr>
        <th>会員ID</th>
        <th>会員名</th>
        <th>受講コース</th>
        <th>回数</th>
        <th>開始時間</th>
        <th>終了時間</th>
        <th class="{sorter: false}">出席状況</th>
        <th class="{sorter: false}">出席状況確定</th>
        <th class="{sorter: false}">お申し込みキャンセル</th>
        </tr>
    </thead>

    <tbody>
    <?php if($row_count !=0)foreach($rows as $row) {
        ?>

        <tr><form method="post" action="">
        <td><?php echo $row['member_id']; ?></td>
        <td><?php echo $row['last_name'].$row['first_name']; ?></td>
        <td><?php echo $row['service_name']. $row['service_title']; ?></td>
        <td><?php echo $row['service_nth_detail']."回目"."--第".$row['service_nth_detail_sub']."回"; ?></td>
        <td><?php echo $row['start_time']; ?></td>
        <td><?php echo $row['end_time']; ?></td>

        <td>
        <input type="radio" name="attend_flg" id="yes" value="1"<?php if($row['attend_flg']==1)  echo "checked";?> > <label for="yes" accesskey="yes">出席</label> 
        <input type="radio" name="attend_flg" id="no" value="0" <?php if($row['attend_flg']==0)  echo "checked";?> > <label for="no" accesskey="no">欠席</label>　
        </td>
        <td>
        <input type="submit" name="confirm" class="button_update" title="update" value="確定" onclick='return confirm("出席更新しますか？");'/>
        <input type="hidden" name="member_id" value="<?=$row['member_id']?>">
        <input type="hidden" name="service_start_id" value="<?=$row['service_start_id']?>">
        <input type="hidden" name="service_nth_detail" value="<?=$row['service_nth_detail']?>">
        <input type="hidden" name="service_nth_detail_sub" value="<?=$row['service_nth_detail_sub']?>">
        </td>


        <td>
        <form action="" method="post">
        <input type="submit" name="cancel" class="button" title="cancel" value="お申し込みキャンセル"　 onclick='return confirm("お申し込みをキャンセルしますか？");'/>                <input type="hidden" name="service_id_new" value="<?=$row['service_name']?>">
        <input type="hidden" name="service_start_id" value="<?=$row['service_start_id']?>">
        <input type="hidden" name="service_title" value="<?=$row['service_title']?>">
        <input type="hidden" name="store_id" value="<?=$row['store_id']?>">
        <input type="hidden" name="member_id" value="<?= $row['member_id']?>">
        </form >
        </td>


        </td>
        </form>

        </tr>
    <?php
    }?>

    </tbody>
    </table>
    </br>
    </br>
    </form>

    <a href="member_service.php"><input type="button" class="button" title="back " value="戻る"></input>  </a>
    </br>
    </br>
    
</body>
</html>
    
<?php endif; ?> 

<?php if($pageFlag ===1): ?>
<?php

  //timezon設定
  date_default_timezone_set('Asia/Tokyo');

    try {
        $pdo = GetDb();

        $updated_date  = date("Y/m/d H:i:s");
        $attend_flg= $_POST['attend_flg'];
        $member_id=$_POST['member_id'];
        $service_start_id=$_POST['service_start_id'];
        $service_nth_detail=$_POST['service_nth_detail'];
        $service_nth_detail_sub=$_POST['service_nth_detail_sub'];


        $sql = 'UPDATE t_member_service_detail SET attend_flg = :attend_flg,updated_date=:updated_date WHERE member_id = :member_id AND  service_start_id=:service_start_id ';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':attend_flg' => $attend_flg,':updated_date'=>$updated_date,':member_id' => $member_id,'service_start_id'=>$service_start_id));  
        
        header("location: member_reservation_attend_sub.php"); 
 
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
    $store_id=$_POST['store_id'];
    $member_id=$_POST['member_id'];
    $service_start_id=$_POST['service_start_id'];

    $sql = 'DELETE FROM t_member_service  WHERE  store_id=:store_id AND member_id =:member_id AND service_start_id =:service_start_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':store_id'=>$store_id,':member_id' => $member_id,':service_start_id' => $service_start_id));  

    $sql = 'DELETE FROM  t_member_service_detail  WHERE  member_id =:member_id AND service_start_id =:service_start_id' ;
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':member_id' => $member_id,':service_start_id' => $service_start_id));  
    

    header('location:member_reservation_attend_sub.php') ;


    } catch(PDOException $e){
echo 'データベースに接続失敗：'.$e -> getMessage();
}

// 接続を閉じる
$pdo = null;

?>

<?php endif; ?>


<?php 

    }
}
?>