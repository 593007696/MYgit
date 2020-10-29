/* 
<form id="form" action="" method="post" onsubmit="return confirm('確認しますか？');">
<input type="submit"　onclick="check_form()">
</form>

*/




function getKey(values, array) {
    for (var key in array) {
        if (array[key] == values) {
            return key;

        }
    }
    return null;
}

function check_form() {
    var getInp = document.getElementById("form").getElementsByTagName("input");
    for (var i in getInp) {

        if (i == "length") break;

        Validity(getInp[i]);

    }
}

//入力エラーチェック
function Validity(inpObj) {

    var validity_array = inpObj.validity;

    inpObj.setCustomValidity(''); //提示初期化


    if (inpObj.checkValidity() == false) {

        if (inpObj.value == "") {
            inpObj.setCustomValidity("入力してください!!!!!");
        }

        var inpError = getKey(true, validity_array);

        switch (inpError) { //既存規則
            case "rangeUnderflow":
                inpObj.setCustomValidity("小さい");
                break;
            case "rangeOverflow":
                inpObj.setCustomValidity("大きい");
                break;

        };

    } else {

        switch (inpObj.value) { //入力禁止規則
            case "111":
                inpObj.setCustomValidity("1!!!!!");
                break;
            case "222":
                inpObj.setCustomValidity("2!!!!!");
                break;

        };

        var rule1 = /^[0-9]{8}$/; //正規表現式定義

        switch (inpObj.id) { //idで絞り込む
            case "1":
                rule1.test(inpObj.value) ? "" : inpObj.setCustomValidity("0-9"); //検証
                break;

        };


    }


}