<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Ticket;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Media;
use Illuminate\Http\Request;
use App\Model\Login;

class TicketController extends Controller
{
    //添加展示页
    public function add(){

        return view('ticket.add');
    }
//添加执行
    public function add_do(){
        //接收值
        $ticket_name = request()->ticket_name;
        $ticket_cations = request()->ticket_cations;
        $ticket_price   = request()->ticket_price;
        //获取access_token
        $access_token = Wechat::getAccessToken();
        dd($access_token);
        //调接口
        $url='https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$access_token;
//        dd($url);
//        $postData = '{"expire_seconds": 604800, "action_name": "QR_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$access_token.'"}}}';
        $postData = [
            'expire_seconds'  => 2592000,
            'action_name'     => 'QR_STR_SCENE',
            'action_info'     =>[
                'scene'  =>[
                   'scene_str'=>$ticket_cations,
                ],
            ],
        ];
        //发送请求
        $postData=json_encode($postData,JSON_UNESCAPED_UNICODE);
        $res = Curl::post($url,$postData);
        $res = json_decode($res,true);
        $ticket = $res['ticket'];

        //入库
        $ass =Ticket::create([
            'ticket_name'    => $ticket_name,
            'ticket_cations' => $ticket_cations,
            'ticket'          => $ticket,
            'ticket_price'   =>  $ticket_price
        ]);
        if($ass){
            echo "<script>alert('渠道添加成功');location='/ticket/list'</script>";
        }else{
            echo "<script>alert('渠道添加失败');location='/ticket/add'</script>";
        }


    }

    //渠道展示
    public function list(){
        $data = Ticket::paginate(2);
//        dd($data);

        return view('ticket.list',['data'=>$data]);
    }


    //图表展示
    public function chart(){
        $data = Ticket::get()->toArray();
//        dd($data);
        $xstr = "";
        $ystr = "";
        foreach($data as $k=>$v){
            $xstr .= '"'.$v['ticket_name'].'",';
            $ystr .= $v['num'].',';
        }
        $xstr =rtrim($xstr,',');
        $ystr =rtrim($ystr,',');
//        dump($xstr);
//        dump($ystr);die;


//        dd($xstr);
        return view('ticket.chart',['xstr'=>$xstr,'ystr'=>$ystr]);
    }

}
