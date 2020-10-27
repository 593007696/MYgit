<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<head>
    <script type="text/javascript">
        $(document).ready(function() {

            /*************セレクトボックスから呼び出し******************************************************* */
            $('#ks').change(function() {

                var time_input_num = $('#ks').val();
                console.log(time_input_num)


                $("#time_input").empty();



                var s_id = new Array();
                var e_id = new Array();
                /********************************時間入力セレクトボックス********************* */
                for (var i = 0; i < time_input_num; i++) {

                    $('#time_input').append(`
                                
                                <label>開始時間:</label>
                                <select name='start_time_base[]' id='start_time_base${i}'>
                                    <option value="0">--:--</option>
                                </select>


                                <span>~</span>

                                <select name='end_time_base[]' id='end_time_base${i}'>
                                    <option value="0">--:--</option>
                                </select>
                                <br>           
                    `);

                    s_id[i] = "#start_time_base" + i;
                    console.log(s_id[i])

                    e_id[i] = "#end_time_base" + i;
                    console.log(e_id[i])


                }
                /************************************************************************ */


                /***********************スタート時間オプション作成********************************************************* */
                $(s_id[0]).focus(function() {

                    $(s_id[0]).children('option').remove();

                    for (var s_h = 0; s_h < 24; s_h++) {
                        for (var s_m = 0; s_m < 60;) {
                            if (s_m < 10) {
                                $(s_id[0]).append(`<option value="${s_h}:0${s_m}">${s_h}:0${s_m}</option>`);
                            } else {
                                $(s_id[0]).append(`<option value="${s_h}:${s_m}">${s_h}:${s_m}</option>`);
                            }

                            s_m = s_m + 15;
                        }
                    };

                })
                /**************************************************************************************** */


                /************************終了時間制限******************************************* */
                $("select[name^='start_time_base']").click(function() {


                    var x_s_id = $(this).attr("id");
                    console.log(x_s_id)

                    var x_s_id_num = x_s_id.substr(x_s_id.length - 1, 1);
                    console.log(x_s_id_num)

                    var now_s_id = "#start_time_base" + x_s_id_num;
                    var s_e_id = "#end_time_base" + x_s_id_num;
                    console.log(now_s_id)
                    console.log(s_e_id)

                    var now_s_t = $(now_s_id).val();
                    console.log(now_s_t)

                    var s_e_h = parseInt(now_s_t.split(":")[0]);
                    console.log(s_e_h)
                    var s_e_m = parseInt(now_s_t.split(":")[1]);
                    console.log(s_e_m)
                    var e_check = isNaN(s_e_m)
                    console.log(e_check)
                    if (e_check) {



                    } else {
                        s_e_m = (s_e_m + 15);
                        $(s_e_id).children('option').remove();
                        for (s_e_h; s_e_h < 24; s_e_h++) {
                            for (s_e_m; s_e_m < 60;) {

                                if (s_e_m < 10) {
                                    $(s_e_id).append(`<option value="${s_e_h}:0${s_e_m}">${s_e_h}:0${s_e_m}</option>`);
                                } else {

                                    $(s_e_id).append(`<option value="${s_e_h}:${s_e_m}">${s_e_h}:${s_e_m}</option>`);
                                }
                                s_e_m = s_e_m + 15;
                            }
                            s_e_m = 0;
                        }
                    }


                })
                /************************************************************************ */


                /***************開始時間制限******************************************** */
                $("select[name^='end_time_base']").click(function() {


                    var x_e_id = $(this).attr("id");
                    console.log(x_e_id)

                    var x_e_id_num = parseInt(x_e_id.substr(x_e_id.length - 1, 1));
                    console.log(x_e_id_num)

                    var now_e_id = "#end_time_base" + x_e_id_num;
                    var next_s_id = "#start_time_base" + (x_e_id_num + 1);
                    var next_e_id = "#end_time_base" + (x_e_id_num + 1);
                    console.log(now_e_id)
                    console.log(next_s_id)
                    console.log(next_e_id)

                    var now_e_t = $(now_e_id).val();
                    console.log(now_e_t)


                    var next_s_h = parseInt(now_e_t.split(":")[0]);
                    console.log(next_s_h)
                    var next_s_m = parseInt(now_e_t.split(":")[1]);
                    console.log(next_s_m)
                    var s_check = isNaN(next_s_m)
                    console.log(s_check)
                    if (s_check) {


                    } else {
                        next_s_m = (next_s_m + 15);
                        console.log(next_s_m)
                        $(next_s_id).children('option').remove();
                        for (next_s_h; next_s_h < 24; next_s_h++) {
                            for (next_s_m; next_s_m < 60;) {

                                if (next_s_m < 10) {
                                    $(next_s_id).append(`<option value="${next_s_h}:0${next_s_m}">${next_s_h}:0${next_s_m}</option>`);
                                } else {

                                    $(next_s_id).append(`<option value="${next_s_h}:${next_s_m}">${next_s_h}:${next_s_m}</option>`);
                                }
                                next_s_m = next_s_m + 15;
                            }
                            next_s_m = 0;
                        }
                    }

                })
                /************************************************************************************************************ */

            });
            /********************************************************************************************** */




        });
    </script>
</head>

<li>
    <label>回数:</label>
    <select class="input" name="ks" id="ks">
        <option value=''>一日中N回</option>
        <?php
        for ($ks = 1; $ks < 6; $ks++) {
        ?>

            <option value='<?= $ks ?>'><?= $ks ?>回</option>
        <?php
        }
        ?>
    </select>

</li>


<li id="time_input">
</li>