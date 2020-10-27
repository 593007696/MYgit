<?php
set_time_limit(0); //ループ時間制限対策

$dns = "mysql:dbname=test;host=localhost;charset=utf8";
$username = "manakuru_0401";
$password = "yoyaku_20200401";
$pdo = new PDO($dns, $username, $password);
$i = 1;
$t_char = "あいうえお";
$t_varchar = "アイウエオ";
$t_text = "aiueo";
$t_date = date("Y-m-d");
$sql = "SELECT * FROM `10-22-test-1`";
$select = $pdo->prepare($sql);
$select->execute();
$y = $select->rowCount();


echo "今現在データペースは" . $y . "件データ存在します。<br>";


if (($y == 0) || (isset($_POST["insert"]))) {


    while ($i < 500001) {
        $sql = "INSERT 
    INTO `10-22-test-1` (`t_int`, `t_char`, `t_date`, `t_varchar`, `t_text`) 
    VALUES ('$i', '$t_char', '$t_date', '$t_varchar', '$t_text');";

        $sql2 = "INSERT 
    INTO `10-22-test-2` (`t_int`, `t_char`, `t_date`, `t_varchar`, `t_text`) 
    VALUES ('$i', '$t_char', '$t_date', '$t_varchar', '$t_text');";
        $into = $pdo->prepare($sql);
        $into->execute();
        if ($into->rowCount() > 0) {
        } else {
            echo $pdo->errorCode();
            print_r($pdo->errorInfo());
            break;
        };

        $into = $pdo->prepare($sql2);
        $into->execute();
        if ($into->rowCount() > 0) {
        } else {
            echo $pdo->errorCode();
            print_r($pdo->errorInfo());
            break;
        };

        $i++;
    }
    $sql = "SELECT * FROM `10-22-test-1`";
    $select = $pdo->prepare($sql);
    $select->execute();
    $y = $select->rowCount();
    echo "データ" . $i . "件インサート成功<br>";

    echo "今現在データペースは" . $y . "件データ存在します。";
}

?>

<?php
if (isset($_POST["delete"])) {
    $sql = "DELETE FROM `10-22-test-1`";
    $delete = $pdo->prepare($sql);
    $delete->execute();
    $y = $delete->rowCount();
}
?>





<form method="post" action="">

    <input type="submit" name="delete" value="delete">

    </from>

    <form method="post" action="">

        <input type="submit" name="insert" value="insert">

        </from>