$(function() {
    // 現在日時
    var current = new Date();

    // 年
    var year_val = current.getFullYear();
    // 月 0（1月）～11（12月） 
    var month_val = current.getMonth() + 1;
    // 日
    var day_val = current.getDate();

    // デフォルト
    $('select[name=year] option[value=' + year_val + ']').prop('selected', true);
    $('select[name=month] option[value=' + month_val + ']').prop('selected', true);
    $('select[name=day] option[value=' + day_val + ']').prop('selected', true);
    setDay();

    // 年/月 選択
    $('select[name=year], select[name=month]').change(function() {
        setDay();
    });

    /**
     * 日プルダウンの制御
     */
    function setDay() {
        year_val = $('select[name=year]').val();
        month_val = $('select[name=month]').val();

        // 指定月の末日
        var t = 31;
        // 2月
        if (month_val == 2) {
            //　4で割りきれる且つ100で割りきれない年、または400で割り切れる年は閏年
            if (Math.floor(year_val % 4) == 0 && Math.floor(year_val % 100) != 0 || Math.floor(year_val % 400) == 0) {
                t = 29;
            } else {
                t = 28;
            }
            // 4,6,9,11月
        } else if (month_val == 4 || month_val == 6 || month_val == 9 || month_val == 11) {
            t = 30;
        }

        // 初期化
        $('select[name=day] option').remove();
        for (var i = 1; i <= t; i++) {
            $('select[name=day]').append('<option value="' + i + '">' + i + '</option>');
        }
    }
});