@extends('layouts.layouts')

@section('title', '渠道添加')

@section('content')


    <form class="form-horizontal" action="{{url('/ticket/add_do')}}" method="post">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">渠道名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail3" placeholder="渠道名称" name="ticket_name">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">渠道标识</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword3" placeholder="渠道标识" name="ticket_cations">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">花费金额</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputPassword3" placeholder="以 W 为单位" name="ticket_price">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">

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