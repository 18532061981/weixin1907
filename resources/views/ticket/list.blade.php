@extends('layouts.layouts')

@section('title', '渠道展示页面')

@section('content')

    <table class="table table-hover">
        <tr>
            <td>渠道id</td>
            <td>渠道名称</td>
            <td>渠道标识</td>
            <td>花费金额</td>
            <td>关注人数</td>
            <td>渠道二维码</td>
        </tr>
        @foreach($data as $k => $v)
        <tr>
            <td>{{$v->ticket_id}}</td>
            <td>{{$v->ticket_name}}</td>
            <td>{{$v->ticket_cations}}</td>
            <td>{{$v->ticket_price}} <b style="color: red">W</b> </td>
            <td>{{$v->num}}</td>
            <td>
                <img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$v->ticket}}" style="height: 100px">
            </td>
        </tr>
        @endforeach
    </table>
    {{$data->links()}}






@endsection