<?php

require('Meting.php');

$api = new Meting('kuwo');

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post'){
    try {
        $k = $_POST['k'];
        $data = $api->format(true)->search($k, ['page' => 1,'limit' => 20]);
        echo json_encode(['code' => 1,'data' => json_decode($data,true)]);die;
    } catch (Exception $e) {
        echo json_encode(['code' => 0,'msg' => $e->getMessage()]);die;
    }
}

if(strtolower($_SERVER['REQUEST_METHOD']) == 'get'){
    try {
        $id = $_GET['id'];
        if(!$id){
            echo json_encode(['code' => 0,'msg' => '参数错误']);die;
        }
        $data = $api->format(true)->url($id);
        $data = json_decode($data,true);
        if($data['url']){
            echo json_encode(['code' => 1,'data' => $data['url']]);die;
        }else{
            echo json_encode(['code' => 0,'msg' => '获取地址失败']);die;
        }
    } catch (Exception $e) {
        echo json_encode(['code' => 0,'msg' => $e->getMessage()]);die;
    }
}
