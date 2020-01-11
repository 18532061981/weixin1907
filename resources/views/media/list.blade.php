@extends('layouts.layouts')

@section('title', '素材管理添加')

@section('content')

    <h3>素材管理--列表展示</h3>

        <table class="table table-hover">
           <tr>
               <td>素材名称</td>
               <td>素材格式</td>
               <td>素材类型</td>
               <td>展示</td>
           </tr>
            @foreach($data as $k=>$v)
            <tr>
                <td>{{$v->me_name}}</td>
                <td>{{$v->me_format}}</td>
                <td>
                    @if($v->me_type==1)
                        临时
                    @else
                        永久
                    @endif
                </td>
                <td>
                    <img src="\{{$v['me_url']}}" style="width: 70px">
                </td>
            </tr>
             @endforeach
        </table>
@endsection