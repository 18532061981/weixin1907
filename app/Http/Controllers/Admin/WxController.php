<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;

class WxController extends Controller
{
    //
    public function wx(){

//        echo request()->input('echostr');
        	$echostr=$_GET['echostr'];
	     echo "$echostr";die;

// 	接入完成之后,微信公众号内用户任何操作 微信服务器=>post形式XML格式发送到配置的url上
        //上传到微信服务器
        $xml =file_get_contents("php://input");
        //接收微信服务器回调数据 并把数据传到文件中,FILE_APPEND是内容追加,\n是换行
        file_put_contents("wx.txt","\n".$xml,FILE_APPEND);
        //好好
        $xmlobj=simplexml_load_string($xml);
        $student = ['陈小狗','陈老狗','刨尸狗','大刚','夜魔','灰','黑狐','赤龙','勾魂鸟','夜枭','大个','烛龙','佟大小姐','白木匠','白狼王','李老太太'];

        //回复消息
        //输出xml数据
//	$fromusername=$xmlobj->FromUserName;
//	$tousername = $xmlobj->ToUserName;
//	$content = $xmlobj->Content;
        //判断是否是关注回复文本消息
        if($xmlobj->MsgType=='event' && $xmlobj->Event=='subscribe'){
            //关注时 获取用户基本信息

            //获取access_token
            $url=" https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxa4148d6e658baa85&secret=b2019135b9ba0acb71a059ddd332622e";
            $data = file_get_contents($url);
            $data= json_decode($data,true);
            $access_token=$data['access_token'];
//            echo $access_token;die;
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$xmlobj->FromUserName.'&lang=zh_CN";

            $data = file_get_contents($url);
            $data= json_decode($data,true);
//            dd($data);
           wechat::reponseText($xmlobj,"谢谢关注");
        }

//判断回复消息
        if($xmlobj->MsgType == 'text') {
            $content = trim($xmlobj->Content);
            if ($content == '1') {
                //回复全部信息
                $msg = implode('|',$student);
                wechat::reponseText($xmlobj, $msg);
            } elseif ($content == '2') {
                //随机回复一人姓名
                $key= array_rand($student,1);

                wechat::reponseText($xmlobj, $student[$key]);
            } elseif(mb_strpos($content,'天气') !== false){
                $city = rtrim($content,"天气");
                if(empty($city)){
                    $city = '北京';
                }
                $url='http://api.k780.com/?app=weather.future&weaid='.$city.'&&appkey=47863&sign=cb278dc6637f3e51c6fbe17b473fe860&format=json';
                $data = file_get_contents($url);
                $data = json_decode($data,true);
                $msg = "";
                foreach($data['result'] as $key => $value){
                    $msg .= $value['days']." ".$value['week']." ".$value['citynm']." ".$value['temperature']."\n";
                }
//		echo $msg;die;
                wechat::reponseText($xmlobj,$msg);
            }
        }


    }







}
