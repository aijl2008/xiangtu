@extends('layouts.app')
@section('title', '全部用户')
@section('content')
    <div id="page-content" class="index-page">
        <div class="container">
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>open_id</th>
                        <th>union_id</th>
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
                            <td>{{$row->open_id}}</td>
                            <td>{{$row->union_id}}</td>
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
            </div>


            <div class="row">
                <div class="featured">
                    <div class="main-vid">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection