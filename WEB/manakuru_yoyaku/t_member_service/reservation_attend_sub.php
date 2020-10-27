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
if(!empty($_POST['u'])){
  $pageFlag = 1;
}

?>


<?php if($pageFlag ===0) :?>

<?php

try {
    $pdo = GetDb();

    $store_id=$_SESSION['store_id_new'];
    $service_id=$_SESSION['service_id_new'];
    $service_name=$_SESSION['service_name_new'];
    $service_title=$_SESSION['service_title_new'];
    $member_id=$_SESSION['member_id_new'];
    $service_start_id=$_SESSION['service_start_id_new'];


    $sql  = "SELECT * FROM  m_member  WHERE member_id = :member_id" ;
    $stmt = $pdo -> prepare($sql);
    $stmt->execute(array(':member_id' =>  $member_id));
    $result = 0;
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql  = "SELECT * FROM t_member_service_detail WHERE service_start_id =:service_start_id  AND member_id=:member_id " ;
    $stmt = $pdo -> prepare($sql);
    $stmt->execute(array(':service_start_id' =>  $service_start_id,':member_id' => $member_id ));

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

</br>
</br>
<?php echo "受講生："."No.".$result['member_id']." ".$result['last_name'].$result['first_name']."　様";?>
</br>
</br>

<form method="post" action="">
    <div class=tb>
    <table id="myTable" class="tablesorter-blue  {sortlist: [[3,0],sortlist: [[4,0]},sortlist: [[5,0]}">

    <thead>
        <tr>
        <th>講座ID</th>
        <th>講座名</th>
        <th>講座タイトル</th>
        <th>講座回数</th>
        <th>開始時間</th>
        <th>終了時間</th>
        <th class="{sorter: false}">出席状況</th>
        <th class="{sorter: false}">出席状況確定</th>
        </tr>
    </thead>

    <tbody>
    <?php if($row_count !=0)foreach($rows as $row) {?>
        <tr><form method="post" action="">
        <td><?php echo $service_id; ?></td>
        <td><?php echo $service_name; ?></td>
        <td><?php echo $service_title;?></td>
        <td><?php echo $row['service_nth_detail']."回目"."--第".$row['service_nth_detail_sub']."回"; ?></td>
        <td><?php echo $row['start_time']; ?></td>
        <td><?php echo $row['end_time']; ?></td>


        <td>
        <input type="radio" name="attend_flg" id="yes" value="1"<?php if($row['attend_flg']==1)  echo "checked";?> > <label for="yes" accesskey="yes">出席</label> 
        <input type="radio" name="attend_flg" id="no" value="0" <?php if($row['attend_flg']==0)  echo "checked";?> > <label for="no" accesskey="no">欠席</label>　
        </td>
        <td>
        <input type="submit" name="u" class="button_update" title="update" value="確定" onclick='return confirm("出席更新しますか？");'/>
        <input type="hidden" name="member_id" value="<?=$row['member_id']?>">
        <input type="hidden" name="service_start_id" value="<?=$row['service_start_id']?>">
        <input type="hidden" name="service_nth_detail" value="<?=$row['service_nth_detail']?>">
        <input type="hidden" name="service_nth_detail_sub" value="<?=$row['service_nth_detail_sub']?>">
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

    <a href="reservation_detail.php"><input type="button" class="button" title="back" value="戻る"></input>  </a>
    </br>
    </br>
    
</body>
</html>

<?php endif;?>


<?php if($pageFlag===1):?>
  
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
           
        $sql = 'UPDATE t_member_service_detail SET attend_flg = :attend_flg,updated_date=:updated_date WHERE member_id = :member_id AND  service_start_id=:service_start_id AND service_nth_detail=:service_nth_detail AND service_nth_detail_sub =:service_nth_detail_sub';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':attend_flg' => $attend_flg,':updated_date'=>$updated_date,':member_id' => $member_id,':service_start_id'=>$service_start_id,':service_nth_detail'=>$service_nth_detail,':service_nth_detail_sub'=>$service_nth_detail_sub));  
            
        header("location: reservation_attend_sub.php"); 

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