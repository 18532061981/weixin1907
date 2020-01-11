<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tools\Wechat;
use App\Tools\Curl;
use App\Model\Media;
use Illuminate\Http\Request;
use App\Model\Login;

class MediaController extends Controller
{
    //素材管理添加视图
   public function add(){
       $access_token = Wechat::getAccessToken();
//        echo $access_token;die;

       return view('media/add');
   }
    //素材管理添加执行
    public function add_show(){
        //接值
        $data = request()->input();
//        dd($data);die;
        $file = request()->file;
        //获取后缀
        $ext=$file->getClientOriginalExtension();
        $filename = md5(uniqid())."."."$ext";
        $path =request()->file->storeAs('');
//        echo $filename;die;
//        dd($ext);
//        dd($file);
        if (!request()->hasFile('file')) {
            //
            echo "没有上传文件";die;
        }
        $filePath = $file->store('images');
//        echo "$filePath";die;
        //获取access_token
        //调用微信上传素材接口
        $access_token = Wechat::getAccessToken();
        $type = "image";
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$access_token."&type=".$type;

        $filePathObj = new \CURLFile(public_path()."/".$filePath);
        //curl发送文件需要通过CURLFile类处理
        //var_dump($filePath);die;
        $postData = ['media'=>$filePathObj];
//        var_dump($postData);die;
        $res = Curl::post($url,$postData);
        $res = json_decode($res,true);
            $meida_id=$res['media_id'];//微信返回的素材id


//        var_dump($res);die;
        //入库
        Media::create([
            'me_name'=>$data['me_name'],
            'me_format'=>$data['me_format'],
            'me_type'=>$data['me_type'],
            'me_url'=>$filePath,  //素材上传地址
            'wechat_media_id'=>$meida_id,
            'add_time'=>time()
        ]);

        if($res){
            echo "<script>alert('添加成功');location='/media/list';</script>";
        }else{
            echo "<script>alert('添加失败');location='/media/add';</script>";
        }



    }

    //素材管理--展示列表
    public function list(){
        $data = Media::paginate(20);
//        dd($data);

            return view('/media/list',['data'=>$data]);
    }

}
