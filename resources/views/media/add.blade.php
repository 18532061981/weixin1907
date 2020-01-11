@extends('layouts.layouts')

@section('title', '素材管理添加')

@section('content')

    <br>
    <br>
    <br>
    <h3>素材管理--添加</h3>
    <br>
    <br>
    <form action="{{url('/media/add_show')}}" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="exampleInputEmail1">素材名称</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="素材名称" name="me_name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">素材格式</label>
            <select name="me_format" id="" class="form-control input-lg">
                <option value="1">图片</option>
                <option value="2">视频</option>
                <option value="3">语音</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">素材类型</label>
            <select name="me_type" id="" class="form-control input-lg">
                <option value="1">临时</option>
                <option value="2">永久</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputFile">素材图片</label>
            <input type="file" id="exampleInputFile" name="file">
        </div>
        <div class="checkbox">

        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
@endsection