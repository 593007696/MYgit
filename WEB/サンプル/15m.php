<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">


    <script type="text/javascript">
    //時間入力欄クリア
        function del() {

            document.getElementById("time").value = null

        }
    </script>

</head>

<?php

if (isset($_POST["time"])) {
    $time = $_POST["time"];
} else {
    $time = "0";
}

echo $time;

?>

<form action="" method="POST">

    <input type='text' list='time_list' name='time' id='time' placeholder='--:--  ⏱' autocomplete='off' onfocus='del()' onclick='del()' style='width:65px;'>

    <datalist id='time_list'>

        <?php

        for ($h = 0; $h < 24; $h++) {

            $m = array('00', '15', '30', '45');

            for ($position = 0; $position < 4; $position++) {
                echo '<option value="' . $h . ':' . $m[$position] . '"></option>';
            }
        }


        ?>


    </datalist>

    <input type="submit">
</form>



</body>

</html>