@extends('layouts.layouts')

@section('title', '新闻添加页')

@section('content')
    {{--搜索--}}
    <form class="form-inline">
        <div class="form-group">
            <label class="sr-only" for="exampleInputEmail3">作者</label>
            <input type="text" class="form-control" id="exampleInputEmail3" placeholder="请输入..." name="new_name" value="{{$query['new_name']??''}}">
        </div>
        <div class="form-group">
            <label class="sr-only" for="exampleInputPassword3">标题</label>
            <input type="text" class="form-control" id="exampleInputPassword3" placeholder="请输入..." name="new_author"  value="{{$query['new_author']??''}}">
        </div>
        <button type="submit" class="btn btn-default">Sign in</button>
    </form>




    <table class="table table-hover">
        <tr>
            <td>标题</td>
            <td>作者</td>
            <td>内容</td>
            <td>时间</td>
            <td>访问量</td>
            <td>操作</td>
        </tr>
        @foreach($data as $k => $v)
        <tr>
            <td>{{$v->new_name}}</td>
            <td>{{$v->new_author}}</td>
            <td>{{$v->new_desc}}</td>
            <td>{{$v->new_at}}</td>
            <td>{{$v->new_access}}</td>
            <td>
                <a href="{{url('/new/delete/'.$v->new_id)}}" class="btn btn-danger">删除</a>|
                <a href="" class="btn btn-info">修改</a>
            </td>
        </tr>
        @endforeach
    </table>
    {{$data->links()}}

@endsection