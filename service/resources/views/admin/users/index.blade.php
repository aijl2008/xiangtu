@extends('layouts.app')
@section('title', '全部用户')
@section('content')
    <h3>用户管理</h3>
    <hr>

    <table class="table table-borderless">
        <tr>
            <th>昵称</th>
            <th>头像</th>
            <th>国家省份城市</th>
            <th>&nbsp;</th>
            <th>注册时间</th>
            <th>足迹</th>
        </tr>
        @foreach($rows as $row)
            <tr>
                <td>{{$row->nickname}}@if($row->sex) <br/>{{$row->sex==1?'男':'女'}} @endif</td>
                <td>
                    @if ($row->avatar)
                        <img src="{{$row->avatar}}" class="avatar-middle">
                    @endif
                </td>
                <td>{{$row->country}}<br>{{$row->province}} {{$row->city}}</td>
                <td>openId:{{$row->open_id}}<br/>unionId:{{$row->union_id}}</td>
                <td>{{$row->created_at}}</td>
                <td><a href="{{route('admin.logs.index', ['wechat_id'=>$row->id])}}">进入</a></td>
            </tr>
        @endforeach
    </table>
    <div class="clearfix"></div>
    <div class="text-center">{{$rows->links()}}</div>
    <div class="clearfix"></div>
@endsection
@section('js')
    <script language="JavaScript">
        $(function () {
            $('#admin_users_index').addClass("active")
        });
    </script>
@endsection