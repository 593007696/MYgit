document.oncontextmenu = new Function("return false");


document.oncontextmenu = function () {

    alert("右クリック禁止");

    return false;

}


document.onkeydown = function () {

    if (window.event.keyCode == 123) {
        alert("F12禁止");
        event.keyCode = 0;
        event.returnValue = false;
    }

    if (window.event.keyCode == 13) {
        window.event.keyCode = 9;
    }

    if (window.event.keyCode == 8) {
        alert(str + "\n delete 使ってください");
        event.keyCode = 0;
        event.returnValue = false;

    }

}