<?php


    $db_hostname    = 'localhost';//データベースのポスト名
    $db_username    = 'root';    //ユーザー
    $db_password    = '';       //パスワード
    $db_name        = 'test';                                                           


    $link = new mysqli( $db_hostname, $db_username, $db_password, $db_name);    


    if (!$link) 
    {                                                                   
        exit( '接続失敗 : mysqli_connect : ' . mysqli_connect_error() );            
    }
    
    
    
    $uname  =   $_POST["uname"];
    $uage   =   $_POST["uage"];
    $ubrith =   $_POST["ubrith"];
    $sql = $link->prepare
    (
        "INSERT INTO 
        test_ajax (uname,uage,ubrith) 
        VALUES 
        (?, ?, ?)"
    );

    $sql->bind_param
    ("sss",$uname,$uage,$ubrith );
    $sql->execute();

  
    $link->close();
    
?>
