<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Ticket;
use Illuminate\Http\Request;
use App\Tools\Wechat;
use App\Model\News;
use App\Model\Users;
use App\Tools\Curl;
use Illuminate\Support\Facades\Redis;

class WeiController extends Controller
{
    //
    public function wei()
    {
//        $echostr =$_GET['echostr'];
//       echo  $echostr;die;

        //上传服务器
        $xml=file_get_contents("php://input");
        //接收
        file_put_contents("wei.txt","\n".$xml,FILE_APPEND);
        $xmlobj=simplexml_load_string($xml);





        //判断是否是关注
        if($xmlobj->MsgType =='event' && $xmlobj->Event=='subscribe'){
            //关注时获取到用户信息
            $userData=Wechat::getUserIndoByOpenId($xmlobj->FromUserName);

//         dd($userData);
//            dd($userData);
            $ticket_cations = $userData['qr_scene_str'];
            //根据渠道标识 关注人数递增
//          dd($ticket_cations);

           Ticket::where(['ticket_cations'=>$ticket_cations])->increment('num');
            $data=[
                'user_name' =>$userData['nickname'],
                'user_sex'  =>$userData['sex'],
                'openid'  =>$userData['openid'],
                'ticket_cations'  =>$userData['qr_scene_str'],
            ];

            Users::create($data);
            $sex = $userData['sex'];
            $nickname= $userData['nickname'];
            if($sex==1){
                $msg = "欢迎".$nickname."先生关注本公众号";
            }elseif($sex==2){
                $msg = "欢迎".$nickname."女士关注本公众号";
            }else{
                $msg = "欢迎".$nickname."先生关注本公众号";
            }
            Wechat::reponseText($xmlobj,$msg);
        }
        //判断是否是取消关注
        if($xmlobj->MsgType == 'event' &&$xmlobj->Event=='unsubscribe'){
            //用户基本信息表 修改状态
            Users::where(['openid'=>$xmlobj->FromUserName])->update(['is_del'=>2]);
            //通过openid 获取用户信息
            $res = Users::where(['openid'=>$xmlobj->FromUserName])->first();
            //通过用户信息获取标识
            $ticket_cations = $res['ticket_cations'];
//            dd($ticket_cations);
            //渠道表自减
            Ticket::where(['ticket_cations'=>$ticket_cations])->decrement('num');
        }





        //判断是否是文本
        if($xmlobj->MsgType=='text'){
            $content = trim($xmlobj->Content); //获取内容
            //回复id最新的新闻
            if($content == '最新新闻'){
                $sql = News::orderBy('new_id','desc')->first();
                $msg = "新闻标题: ".$sql['new_name']."\n"."新闻作者: " .$sql['new_author']." \n"."新闻内容: " .$sql['new_desc'];
//                dd($msg);
                Wechat::reponseText($xmlobj,$msg);
            }
            //根据关键字搜索内容
            if(mb_strpos($content,"新闻")!==false){
                $ass = mb_substr($content,2);
                $sql = News::where('new_name','like',"%$ass%")->get()->toArray();
                $msg = "新闻标题:".$sql[0]['new_name']."\n"."新闻内容 :".$sql[0]['new_desc'];
                Wechat::reponseText($xmlobj,$msg);
            }
        }
        $openid = $xmlobj->FormUserName;  //获取openid
        $msg_type=$xmlobj->MsgType;        //获取消息类型
        if($msg_type == 'image'){           //图片
            //下载图片

        }



    }




    /**
     * 获取最新access_token 并换缓存
     */
    public function freshToken()
    {
        $redis_weixin_token_key = 'weixin_access_token';
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxa4148d6e658baa85&secret=b2019135b9ba0acb71a059ddd332622e';
        //请求接口
        $json = file_get_contents($url);
        $arr = json_decode($json,true);
        $token = $arr['access_token'];
        //缓存token]
        Redis::set($redis_weixin_token_key,$token);
        Redis::expire($redis_weixin_token_key,3600);
        echo "token已刷新 " . date("Y-m-d H:i:s");echo '</br>';
        echo $token;
    }


    //创建菜单
    public function createMenu()
    {
        $access_token = Wechat::getAccessToken();
        //echo date("Y-m-d H:i:s");echo '</br>';
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' .$access_token;
        //echo $url;echo '</br>';
        $postData= [
            "button"    => [
                [
                    "type"  => "click",
                    "name"  => "1906",
                    "key"   => "1907weixin"
                ],
                [
                    "name"  => "二级菜单",
                    "sub_button"    => [
                        [
                            "type"  => "scancode_push",
                            "name"  => "扫一扫",
                            "key"   => "scan111"
                        ],[
                            "type"=> "view",
                           "name"=> "搜索",
                           "url"=> "https://www.baidu.com/"
                        ],[
                           "type"=> "view",
                           "name"=> "淘宝",
                           "url"=> "https://www.taobao.com/"
                        ],
                        [
                            "name"=> "发送位置",
                             "type"=> "location_select",

                            "key"=> "rselfmenu_2_0"
                        ],
                        [
                            "type"  => "pic_sysphoto",
                            "name"  => "拍照",
                            "key"   => "photo111"
                        ]
                    ]
                ],
            ]
        ];
        $postData =json_encode($postData,JSON_UNESCAPED_UNICODE);
        $res = Curl::post($url,$postData);
        $res = json_decode($res,true);
        dd($res);
    }



    //根据openid群发
    public function sendall(){
        $access_token = Wechat::getAccessToken();
        $users = Users::select('openid')->get()->toArray();
        $openid_list = array_column($users,'openid');
        // openid 列表  可以从数据库表获取
        $msg = date("Y-m-d H:i:s")  . "马上放寒假";
        echo "消息： ".$msg;echo '</br>';
        $json_data = [
            "touser"    => $openid_list,
            "msgtype"   => "text",
            "text"      => [
                "content"   => $msg
            ]
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$access_token;
        $response = Users::post($url,$json_data);
        // 检查错误
        if($response['errcode'] > 0){
            echo '错误信息： ' . $response['errmsg'];
        }else{
            echo "发送成功";
        }
    }
}
