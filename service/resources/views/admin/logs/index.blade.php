@extends('layouts.app')
@section('title', '事件管理')
@section('content')
    <h3>事件管理</h3>
    <hr>
    @include('layouts/message')
    <table class="table table-borderless">
        <thead>
        <tr>
            <th>编号</th>
            <th class="text-nowrap">行为</th>
            <th class="text-nowrap">用户</th>
            <th class="text-nowrap">消息</th>
            <th class="text-nowrap">更新时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
            <tr>
                <td class="text-nowrap">{{ $row->id }}</td>
                <td class="text-nowrap">{{ $row->action }}</td>
                <td class="text-nowrap">{{ $row->from_user_id }}</td>
                <td class="text-nowrap">{{ $row->message }}</td>
                <td class="text-nowrap">{{ $row->updated_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! $rows->render() !!}
@stop
@section('js')
    <script language="JavaScript">
        $(function () {
            $('#admin_logs_index').addClass("active")
        });
    </script>
@endsection
