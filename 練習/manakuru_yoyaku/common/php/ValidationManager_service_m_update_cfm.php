<?php

    function validation($data){

        $error = array();

        if(empty($data['store_id']) ){
            $error[] ='店舗を入力してください。';
        }

        if(empty($data['service_name']) ){
            $error[] ='サービス名を入力してください。';
        }

        if(!isset($data['service_title'])){
            $error[] ='タイトル(講座名/職種)を入力してください。';
        }

        if(!isset($data['service_flg']) ){
            $error[] ='サービス単位を選択してください。';
        }

        if(empty($data['frequency']) ){
            $error[] ='コマ数を入力してください。';
        }elseif (!(preg_match('/^[0-9]+$/', $data['frequency']))) {
            $error[] ='コマ数は半角英数で入力してください。';
        }

        if(empty($data['month']) ){
            $error[] ='月数を入力してください。';
        }

        if(empty($data['target']) ){
            $error[] ='対象者を入力してください。';
        }

        if(empty($data['overview']) ){
            $error[] ='概要を入力してください。';
        }

        if(empty($data['price']) ){
            $error[] ='料金を入力してください。';
        }elseif (!(preg_match('/^[0-9]+$/', $data['price']))){
            $error[] ='料金は半角英数で入力してください。';
        }

        if(!isset($data['open_flg'])){
            $error[] = '開始状態を選択してください。';
        }

        return $error;
    }

?>