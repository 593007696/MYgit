<!DOCTYPE html>

<head>
<title>予約一覧表</title>
</head>

 <!-- テーブル -->
 <script  
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
        <script src="../common/js/jquery.tablesorter.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="../common/js/jquery.metadata.js" type="text/javascript" charset="utf-8"></script>
        <script src="../common/js/PaginateMyTable.js" type="text/javascript" charset="utf-8"></script>
        <script src="../common/js/Speech_bubble.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
        $(document).ready(function(){ 
            $("#myTable").tablesorter();
            $("#myTable").paginate({ //PaginateMyTable
                rows: 10,          // Set number of rows per page. Default: 5
                position: "bottom",   // Set position of pager. Default: "bottom"
                jqueryui: true,    // Allows using jQueryUI theme for pager buttons. Default: false
                showIfLess: false  // Don't show pager if table has only one page. Default: true
            });
        }); 
        </script>

    <!-- テーマ用CSS -->
    <link rel="stylesheet" href="../common/css/theme.blue.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="../common/css/PaginateMyTable.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" href="../common/css/style.css" type="text/css">
    <link rel="stylesheet" href="../common/css/arrows.css" type="text/css">
<html>
<body>

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


    $r=filter_input(INPUT_POST,"r");
    if($r=="予約キャンセル") {


        try {
            $pdo = GetDb();

            //------------------------
            //DELETE（prepare→execute）
            //------------------------

            $member_id=$_POST['member_id'];
            $start_time=$_POST['start_time'];

            $sql = 'DELETE FROM t_member_service_detail WHERE member_id = :member_id AND start_time = :start_time ';
            $stmt = $pdo->prepare($sql);
            $delete_date  = date("Y/m/d H:i:s");
            $stmt->execute(array(':member_id' =>  $member_id,':start_time' =>  $start_time));  
            //$result = $stmt->execute();
        
            header('location:time_service_delete.php') ;
            
        } catch (Exception $e) {
            echo 'エラーが発生しました。:' . $e->getMessage();
        }

    }else{

        //timezon設定
        date_default_timezone_set('Asia/Tokyo');

        //データベース接続&新規登録処理
        require_once('../common/php/DbManager.php');

        $member_id=$_POST['member_id'];

        try {

            $pdo = GetDb();

            //当日コワーキング
            $sql  = "SELECT * FROM t_member_service_detail LEFT JOIN t_service_set using(`service_start_id`) LEFT JOIN m_service using(`service_id`) JOIN m_member using(`member_id`) WHERE member_id=:member_id AND service_flg='1'" ;
            $stmt = $pdo -> prepare($sql);
            $stmt->execute(array(':member_id'=>$member_id));
            
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

        <p>予約一覧表</p>
        <div class=tb>
        <table id="myTable" border="1" class="tablesorter-blue  {sortlist: [6,0]}">
            <thead>
                <tr>
                    <th>店舗</th>
                    <th>部屋</th>
                    <th>会員ID</th>
                    <th>会員名</th>
                    <th>利用時間</th>
                    <th>開始時間</th>
                    <th>終了時間</th>
                    <th>削除</th>
                </tr>
            </thead>

            <tbody>
            <?php if($c_count !=0){foreach($cs as $c) {?>
                <!--当日の講座を検索する-->
                <tr>
                        <?php  
                            $timestamp1 = strtotime($c['start_time']); 
                            $timestamp2 = strtotime($c['end_time']);
                            $diff_hour = ($timestamp2 - $timestamp1) /60/60;
                        ?>

                        <td><?php echo $c['store_id']; ?></td>
                        <td><?php echo $c['room_id']; ?></td>
                        <td><?php echo $c['member_id']; ?></td>
                        <td><?php echo $c['last_name'].$c['first_name']; ?></td>
                        <td><?php echo $diff_hour."時間" ?></td>
                        <td><?php echo $c['start_time'] ?></td>
                        <td><?php echo $c['end_time'] ?></td>

                        <td>
                            <form action="" method="post">
                                <input type="submit" class="button" name="r" value="予約キャンセル" onclick='return confirm("予約キャンセルしますか？");'/></input>
                                <input type="hidden" name="member_id" value="<?=$c['member_id']?>">
                                <input type="hidden" name="start_time" value="<?=$c['start_time']?>">
                            </form>
                        </td>
                        <?php
                        }
                        ?>
                    </tr>
                
            <?php
            }
            ?>
 
            </tbody>
            </table>

    </html>
    </body>

<?php
        }
    ?>

<?php 
}
    }
?>

