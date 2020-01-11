@extends('layouts.layouts')

@section('title', '新闻添加页')

@section('content')
    <form class="form-horizontal" action="{{url('/new/add')}}" method="post">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">新闻标题</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="new_name" id="inputEmail3" placeholder="新闻标题">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">新闻作者</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="new_author" id="inputEmail3" placeholder="新闻作者">
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">新闻内容</label>
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <textarea class="form-control" name="new_desc" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Sign in</button>
            </div>
        </div>
    </form>


@endsection