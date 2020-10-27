$(function () {
    // 現在の年月日を取得
    var B_time = new Date();
    var B_year = B_time.getFullYear();
    var B_month = B_time.getMonth() + 1;
    var B_date = B_time.getDate();

    // 選択された年月日を取得
    var selected_year = document.getElementById("B_year").value;
    var selected_month = document.getElementById("B_month").value;

    // 年(初期): 1900〜現在の年 の値を設定
    for (var i = B_year; i >= 1900; i--) {


        $('#B_year').append(`<option value="${i}">${i}</option>`);
    }

    // 月(初期): 1~12 の値を設定
    for (var j = 1; j <= 12; j++) {
        $('#B_month').append(`<option value="${j}">${j}</option>`);
    }

    // 日(初期): 1~31 の値を設定
    for (var k = 1; k <= 31; k++) {
        $('#B_date').append(`<option value="${k}">${k}</option>`);
    }

    // 月(変更)：選択された年に合わせて、適した月の値を選択肢にセットする
    $('#B_year').change(function () {
        selected_year = $('#B_year').val();

        // 現在の年が選択された場合、月の選択肢は 1~現在の月 に設定
        // それ以外の場合、1~12 に設定
        var last_month = 12;
        if (selected_year == year) {
            last_month = B_month;
        }
        $('#B_month').children('option').remove();
        $('#B_month').append(`<option value="${0}">--</option>`);
        for (var n = 1; n <= last_month; n++) {
            $('#B_month').append(`<option value="${n}">${n}</option>`);
        }
    });

    // 日(変更)：選択された年・月に合わせて、適した日の値を選択肢にセットする
    $('#B_year,#B_month').change(() => {
        selected_year = $('#B_year').val();
        selected_month = $('#B_month').val();

        // 現在の年・月が選択された場合、日の選択肢は 1~現在の日付 に設定
        // それ以外の場合、各月ごとの最終日を判定し、1~最終日 に設定
        if (selected_year == B_year && selected_month == B_month) {
            var last_date = B_date;
        } else {
            // 2月：日の選択肢は1~28日に設定
            // ※ ただし、閏年の場合は29日に設定
            if (selected_month == 2) {
                if ((Math.floor(selected_year % 4 == 0)) && (Math.floor(selected_year % 100 != 0)) || (Math.floor(selected_year % 400 == 0))) {
                    last_date = 29;
                } else {
                    last_date = 28;
                }

                // 4, 6, 9, 11月：日の選択肢は1~30日に設定
            } else if (selected_month == 4 || selected_month == 6 || selected_month == 9 || selected_month == 11) {
                last_date = 30;

                // 1, 3, 5, 7, 8, 10, 12月：日の選択肢は1~31日に設定
            } else {
                last_date = 31;
            }
        }

        $('#B_date').children('option').remove();
        $('#B_date').append(`<option value="${0}">--</option>`);
        for (var m = 1; m <= last_date; m++) {
            $('#B_date').append(`<option value="${m}">${m}</option>`);
        }
    });

});