<?php



$access_token = "29_e7pIYDo8CbyYv3Uutvu2tTpT40m3XtdvpjL8rCaMk8TZ5f3JOXtBmqgyBy32NjHUGXAcp1sG99wFhizzuo7ONvEBhbGrjFoPKGFp5JH8vJv9uCazbWXOLCAB1Xc3_QiHhs1_wp7PYdyjLTlwZNViAFADRZ";
$url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=image";

//发送请求post
$img = "D:\\phpstudy_pro/O1CN01tzSD2Q1oifSxyk2p0_!!0-saturn_solar.jpg_220x220.jpg";
$img  = new \CURLFile($img);
$postData['media'] = $img;
$res = curlPost($url,$postData);
var_dump($res);die;
function curlPost($url,$postData){
    $curl = curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);//设置请求地址
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);//返回数据格式
    curl_setopt($curl,CURLOPT_POST,1);//设置以post发送
    curl_setopt($curl,CURLOPT_POSTFIELDS,$postData);//设置post发送的数据
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);//关闭HTTPS验证
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, false);//关闭https验证
    $output =curl_exec($curl);
    curl_close($curl);
    return $output;
}
