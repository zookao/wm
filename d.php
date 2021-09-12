<?php
$url = urldecode($_GET['url']);
if(!strstr($url,'http')){
    $url = 'http:'.$url;
}
file_put_contents('log.txt',$url.PHP_EOL,FILE_APPEND);
$fileres = file_get_contents($url);
$name = uniqid().'.mp4';
file_put_contents($name,$fileres);

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods:GET');
header('Access-Control-Allow-Headers:*');
$file = fopen ($name,"rb");
Header ("Content-type: application/octet-stream" );
Header ("Accept-Ranges: bytes" );
Header ("Accept-Length: " . filesize ($name));
Header ("Content-Disposition: attachment; filename=".$name);
echo fread ($file, filesize ($name));
fclose ($file);
unlink($name);
exit ();
