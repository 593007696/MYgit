<!-- postデータセキュリティー強化-->
<?php
function  security($str)
{
    return trim(strip_tags(addslashes(htmlspecialchars($str, ENT_QUOTES, 'UTF-8'))));
    //スペース削除 trim(); 

    //htmlタグ削除 strip_tags();

    //正規化 htmlspecialchars(); 

    //SQL注入対策 addslashes();
}

if (isset($_POST)) {
    foreach ($_POST as $key => $value) {
        if (is_array($_POST[$key])) {
            $value_num = count($value);
            $key_num = 0;
            while ($key_num < $value_num) {

                if (is_array($value[$key_num])) {

                    $values[] =  $value[$key_num];
                } else {

                    $values[] =  security($value[$key_num]);
                }

                $key_num++;
            }
            $value = 0;
            $value = $values;
            $_POST[$key] = $value;
            $values = array();
        } else {
            $_POST[$key] =   security($_POST[$key]);
        }
    }
}
?>