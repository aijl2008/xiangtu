@extends('layouts.app')
@section('title', '日志管理')
@section('content')
    <h3>日志管理</h3>
    <hr>
    @include('layouts/message')
    <div class="table-responsive">
        <table class="table table-condensed">
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
                    <td class="text-nowrap">{{ $row->from_user->nickname }}</td>
                    <td class="text-nowrap">
                        {!! $row->formatted_message  !!}
                    </td>
                    <td class="text-nowrap">{{ $row->updated_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    {!! $rows->render() !!}
@stop
@section('js')
    <script language="JavaScript">
        $(function () {
            $('#admin_logs_index').addClass("active")
        });
    </script>
@endsection
