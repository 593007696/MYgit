<!DOCTYPE HTML>

<html>

<head>

    <title>入力</title>

    <meta　charset="UTF-8">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        function dbajax() {

            $.ajax({
                async: false,
                type: "POST", //方式

                url: "Ajaxphp.php", //受取先

                data: $('#list').serialize(),

                //成功
                success: function(date) {
                    /*var msg=document.getElementById("msg");
                    msg.innerHTML="成功!";
                    */
                    alert("AJAX 成功");

                },
                //失敗
                error: function() {
                    /*var msg=document.getElementById("msg");
                    msg.innerHTML="失敗!";
                    */
                    alert("AJAX 失敗");
                }

            });

        }
    </script>

</head>

<body>
    <h1>このページ</h1>
    <p>

        <form id="list">

            <p>
                <label for="uname">名前:</label>
                <input name="uname" id="uname" type="text" />
            </p>

            <p>
                <label for="uage">年齢:</label>
                <input name="uage" id="uage" type="number" />
            </p>

            <p>
                <label for="ubrith">誕生日:</label>
                <input name="ubrith" id="ubrith" type="date" />
            </p>

            <p>
                <input type="button" value="GO" onclick="dbajax()">
            </p>

            <!--<p><p id="msg"></p></p>-->

        </form>

    </p>
    <?php

    $uname  =   isset($_POST["uname"]) ? $_POST["uname"] : "";
    $uage   =   isset($_POST["uage"]) ? $_POST["uage"] : "";
    $ubrith =   isset($_POST["ubrith"]) ? $_POST["ubrith"] : "";




    ?>

</body>

</html>