<?php

    function validation($data){

        $error = array();

        if(empty($data['number']) ){
            $error[] ='回数を入力してください。';
        }elseif (!(preg_match('/^[0-9]+$/', $data['number']))) {
            $error[] ='回数は半角数字で入力してください';
        }

        if(empty($data['service_detail_content']) ){
            $error[] ='内容を入力してください。';
        }

        if(empty($data['service_detail_time']) ){
            $error[] ='時間を入力してください。';
        }elseif (!(preg_match('/^[0-9]+$/', $data['service_detail_time']))) {
            $error[] ='時間は半角英数で入力してください。';
        }

        return $error;
    }

?>