<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Tools\Wechat;
use Illuminate\Http\Request;
use App\Model\News;

class NewsController extends Controller
{
    //展示页
    public function index(){
//        echo Wechat::getAccessToken();die;
        return view('new.index');
    }
    //添加执行

    public function add(){
        //接收全部数据
        $data = request()->all();
//        dd($data);
        $res = News::insert($data);
//        dd($res);
        if($res){
            echo "<script>alert('添加成功');location='/new/list'</script>";
        }else{
            echo "<script>alert('添加失败');location='/new/index'</script>";
        }

    }
    //新闻展示页
    public function list(){
        //搜索
        $new_name = request()->new_name;
        $new_author = request()->new_author;
//        dump($new_name);
        $where=[];
        if($new_name){
            $where[]=['new_name','like',"%$new_name%"];
        }
        if($new_author){
            $where[]=['new_author','like',"%$new_author%"];
        }

        $data = News::where($where)->paginate(5);
//        dd($data);
        $query=request()->all();
        return view('new.list',['data'=>$data,'query'=>$query]);
    }

    //删除
    public function delete($new_id){
//        dd($new_id);
    $res = News::where('new_id',$new_id)->delete();
        if($res){
            echo "<script>alert('删除成功');location='/new/list'</script>";
        }else{
            echo "<script>alert('删除失败');location='/new/list'</script>";
        }

    }


}
