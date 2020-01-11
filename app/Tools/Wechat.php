<?php
namespace App\Tools;
use Illuminate\Support\Facades\Cache;

/**
 * 微信核心类
 */
class Wechat
{
    //
    /**
     * @param $xmlobj
     * @param $msg
     * 回复文本消息
     */
    const appId ='wxa4148d6e658baa85';
    const appSerect = 'b2019135b9ba0acb71a059ddd332622e';

   public static function reponseText($xmlobj,$msg){
        echo "<xml>
  <ToUserName><![CDATA[".$xmlobj->FromUserName."]]></ToUserName>
  <FromUserName><![CDATA[".$xmlobj->ToUserName."]]></FromUserName>
  <CreateTime>".time()."</CreateTime>
  <MsgType><![CDATA[text]]></MsgType>
  <Content><![CDATA[".$msg."]]></Content>
</xml>"
        ;die;

    }


    public static function getAccessToken(){
        //先判断是否有数据
        $access_token = Cache::get('access_token');
//        dd($access_token);

        //有数据之间返回
        if(empty($access_token)){
            //获取access_token(微信接口调用凭证)
            $url ="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".Self::appId."&secret=".Self::appSerect;
            $data=file_get_contents($url);
            $data=json_decode($data,true);
            $access_token = $data['access_token'];
            Cache::put('access_token',$access_token,7200);
        }
        //没有数据再进去调微信接口获取 -> 存入缓存
        return $access_token;

    }

    /**
     * @param $openid
     * @return mixed|string
     * 获取用户信息
     */
    public static function getUserIndoByOpenId($openid){
        //获取token
        $access_token =Self::getAccessToken();
        $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $data = file_get_contents($url);
        $data = json_decode($data,true);
        return $data;
    }


}
