<?php
$url = 'https://www.hlapi.cn/api/djt';
$content = file_get_contents($url);
if($content){
    echo json_encode(['code' => 1 ,'msg' => 'successs','data' => trim($content)]);
}else{
    echo json_encode(['code' => 0,'msg' => '请求失败，请重试']);
}
