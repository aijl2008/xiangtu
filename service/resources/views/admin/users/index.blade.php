@extends('layouts.app')
@section('title', '全部用户')
@section('content')
    <h3>用户管理</h3>
    <hr>
    <table class="table table-borderless">
        <tr>
            <th>昵称</th>
            <th>头像</th>
            <th>sex</th>
            <th>country</th>
            <th>province</th>
            <th>city</th>
            <th>created_at</th>
        </tr>
        @foreach($rows as $row)
            <tr>
                <td>{{$row->nickname}}</td>
                <td>
                    @if ($row->avatar)
                        <img src="{{$row->avatar}}">
                    @endif
                </td>
                <td>{{$row->sex}}</td>
                <td>{{$row->country}}</td>
                <td>{{$row->province}}</td>
                <td>{{$row->city}}</td>
                <td>{{$row->created_at}}</td>
            </tr>
        @endforeach
    </table>
    <div class="text-center">{{$rows->links()}}</div>
@endsection