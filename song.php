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
            file_put_contents('log.txt',$data['url'].PHP_EOL,FILE_APPEND);
            $fileres = file_get_contents($data['url']);
            $name = uniqid().'.mp3';
            file_put_contents($name,$fileres);

            header("Access-Control-Allow-Origin: *");
            header('Access-Control-Allow-Methods:GET');
            header('Access-Control-Allow-Headers:*');
            $file = fopen($name,"rb");
            Header("Content-type: application/octet-stream");
            Header("Accept-Ranges: bytes");
            Header("Content-Length: ".filesize($name));
            Header("Content-Disposition: attachment; filename=".$name);
            echo fread($file, filesize($name));
            fclose($file);
            unlink($name);
            exit();
        }else{
            echo json_encode(['code' => 0,'msg' => '获取地址失败']);die;
        }
    } catch (Exception $e) {
        echo json_encode(['code' => 0,'msg' => $e->getMessage()]);die;
    }
}
