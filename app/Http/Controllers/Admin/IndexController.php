<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Curl;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //后天首页展示
    public function index(){

        return view('admin.index');
    }
    public  function  index_v1(){
        $city = request()->city;
        $url='http://api.k780.com/?app=weather.future&weaid='.$city.'&&appkey=47863&sign=cb278dc6637f3e51c6fbe17b473fe860&format=json';
//        dump($city);
        $data = Curl::get($url);
//        dd($data);
        //时间
        $week ="";
        //温度
        $temperature ="";
        foreach($data as $k=>$v){
            if(is_array($v)){
                $v = trim($v);
                $week = $v['week'];
                $temperature = $v['temperature'];
            }
        }

        dump($week);
        dump($temperature);die;




        return view('admin.index_v1');
    }



}
