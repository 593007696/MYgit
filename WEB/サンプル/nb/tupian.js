
//右键菜单
$(document).ready(function ($) {
    $("#tupian").mousedown(function (e) {
        if(e.which==3){
        	showMessage("<a href=\"https://www.yahoo.co.jp/?fr=top_ga1_ext1_bookmark\">行ってみる？</a>  ",10000);
            
        }
    });
    //不显示默认网页右键菜单
	$("#tupian").bind("contextmenu", function(e) {
	    return false;
	});
});

//鼠标在上方时
$(document).ready(function ($) {
    $(".doubi").mouseover(function () {
       $(".doubi").fadeTo("300", 0.3);
       msgs = [
            "見えない~",
            "忍！",
            "どけ！！どけ！！",
            "忙しそう~",
            "眠い~",
            "梦ならばどれほどよかったでしょう~",
            "何をしている？",
            "時には誰かを知らず知らずのうちに",
            "遊ぼう？",
        ];
       var i = Math.floor(Math.random() * msgs.length);
        showMessage(msgs[i]);
    });
    $(".doubi").mouseleave(function () {
        $(".doubi").fadeTo("300", 1)
    });
});
//放置  
var tokei=setInterval(function(){myTime()},1000);
function myTime(){
    var d=new Date();
    var t=d.toLocaleTimeString();
    document.getElementById("time").innerHTML=t;
};           
$(document).ready(function ($) {
    var id = 0;
    $(document).mousemove(function(){
    clearInterval(id);
    id = setInterval("$('.doubi').mousedown()",5000);
    });

    $(".doubi").mousedown(function(e){
        e.which=2
        msgs = 
        [
            "今の時間教えてあげる~",
            "今は"+'<a id="time"></a><br>' ,
            "今は何時？",
            
        ];
       var i = Math.floor(Math.random() * msgs.length);
        showMessage(msgs[i]);

        });
});

//スタート
$(document).ready(function ($) {
	var url = window.location.href;
	var title = document.title;
    if (url.indexOf('/p/') < 0) { 
        var now = (new Date()).getHours();
        if (now > 0 && now <= 6) {
            showMessage(' 寝ないの？明日大丈夫？'+title+'へようこそ!'+visitor,10000);
        } else if (now > 6 && now <= 11) {
            showMessage(' おはよう~'+title+'へようこそ!'+visitor,10000);
        } else if (now > 11 && now <= 14) {
            showMessage('昼飯食べた？'+title+'へようこそ!'+visitor,10000);
        } else if (now > 14 && now <= 20) {
            showMessage('今日も頑張りましたね~'+title+'へようこそ!'+visitor,10000);
        }else if (now > 20 && now <= 23) {
            showMessage('早く寝なさい~'+title+'へようこそ!'+visitor,10000);
        }
    }else {
        showMessage('いらっしゃいませ~'+ title+'へようこそ' ,10000);
    }
   
});


//鼠标点击时
$(document).ready(function ($) {
        var stat_click = 0;
        $(".doubi").click
        (function () {
        if (!ismove) 
        {stat_click++;
            if (stat_click > 4) 
                {
                    msgs = ["さわるな！",  stat_click + "回目触った！"];
                    var i = Math.floor(Math.random() * msgs.length);
                } 
                else 
                {
                    msgs = ["発車！", "ニゲ~ルウ~", "おもろい？","さわるな！！"];
                    var i = Math.floor(Math.random() * msgs.length);
                }
                s = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6,0.7,0.75,-0.1, -0.2, -0.3, -0.4, -0.5, -0.6,-0.7,-0.75];
                var i1 = Math.floor(Math.random() * s.length);
                var i2 = Math.floor(Math.random() * s.length);
                    
                    $(".tupian").animate(
                        {
                            left: document.body.offsetWidth/2*(1+s[i1]),
                            top:  document.body.offsetHeight/2*(1+s[i2])
                        },
                        {
                            duration: 500,
                            complete: showMessage(msgs[i])
                        }
                    );
            } 
                    else { ismove = false;}
            }
        );
    }
);

//显示消息函数 
function showMessage(a, b) {
    if (b == null) b = 10000000;
    $("#message").hide().stop();
    $("#message").html(a);
    $("#message").fadeIn();
    $("#message").fadeTo("1", 1);
    $("#message").fadeOut(b);
};

//拖动
var _move = false;
var ismove = false; //移动标记
var _x, _y; //鼠标离控件左上角的相对位置
$(document).ready(function ($) {
    $("#tupian").mousedown(function (e) {
        _move = true;
        _x = e.pageX - parseInt($("#tupian").css("left"));
        _y = e.pageY - parseInt($("#tupian").css("top"));
     });
    $(document).mousemove(function (e) {
        if (_move) {
            var x = e.pageX - _x; 
            var y = e.pageY - _y;
            var wx = $(window).width() - $('#tupian').width();
            var dy = $(document).height() - $('#tupian').height();
            if(x >= 0 && x <= wx && y > 0 && y <= dy) {
                $("#tupian").css({
                    top: y,
                    left: x
                }); //控件新位置
            ismove = true;
            }
        }
    }).mouseup(function () {
        _move = false;
    });
});

