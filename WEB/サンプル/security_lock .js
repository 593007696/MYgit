
document.oncontextmenu = new Function("return false");


document.oncontextmenu = function(e) {

    alert("右クリック禁止");

    return false;

}


document.onkeydown = function() {

    if (window.event && window.event.keyCode == 123) {
        alert("F12禁止");
        event.keyCode = 0;
        event.returnValue = false;
    }
    if (window.event && window.event.keyCode == 13) {
        window.event.keyCode = 505;
    }
    if (window.event && window.event.keyCode == 8) {
        alert(str + "\n delete 使ってください");
        window.event.returnValue = false;
    }

}
