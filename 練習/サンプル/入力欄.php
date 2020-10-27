<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <title>入力</title>


</head>

<body>
    1、输入框景背景透明：
    <input style="border:0;border-bottom:1 solid black;">
    <br>

    2、鼠标划过输入框，输入框背景色变色：
    <INPUT value="Type here" NAME="user_pass" TYPE="text" SIZE="29"
        onmouseover="this.style.borderColor='black';this.style.backgroundColor='plum'" style="width: 106; height: 21"
        onmouseout="this.style.borderColor='black';this.style.backgroundColor='#ffffff'"
        style="border-width:1px;border-color=black">
    <br>
    3、输入字时输入框边框闪烁(边框为小方型)：
    <Script Language="JavaScript">
        function borderColor() {
            if (self['oText'].style.borderColor == 'red') {
                self['oText'].style.borderColor = 'yellow';
            } else {
                self['oText'].style.borderColor = 'red';
            }
            oTime = setTimeout('borderColor()', 400);
        }
    </Script>
    <input type="text" id="oText" style="border:5px dotted red;color:red" onfocus="borderColor(this);"
        onblur="clearTimeout(oTime);">
    <br>
    4、自动向下廷伸的文本框：
    <textarea name="content" rows="6" cols="80"
        onpropertychange="if(this.scrollHeight>80) this.style.posHeight=this.scrollHeight+5">输入几个回车试试</textarea>
    <br>


</body>

</html>