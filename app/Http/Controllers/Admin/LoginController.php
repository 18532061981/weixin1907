<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Login;

class LoginController extends Controller
{
    //登录首页
    public function login(){

        return view('admin.login');
    }

    public function add(){
        $data  = request()->all();
//        $l_pwd  = request()->l_pwd;
//        dump($data);
        $where[]=[
            'l_name','=',$data['l_name']
        ];
        $info = Login::where($where)->first();
//        dd($info);
        if($info){
            if($data['l_pwd']==$info['l_pwd']){
                echo "<script>alert('登录成功');location='/admin/index'</script>";
            }else{
                echo "<script>alert('账号或密码错误');location='/admin/login'</script>";
            }
        }else{
            echo "<script>alert('账号或密码错误');location='/admin/login'</script>";
        }

    }

}
