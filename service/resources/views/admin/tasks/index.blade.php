@extends('layouts.app')
@section('title', '事件管理')
@section('content')
    <h3>事件管理</h3>
    <hr>
    @include('layouts/message')
    <div class="table-responsive">
        <table class="table table-condensed">
            <thead>
            <tr>
                <th>编号</th>
                <th class="text-nowrap">video</th>
                <th class="text-nowrap">file_id</th>
                <th class="text-nowrap">task_id</th>
                <th class="text-nowrap">code</th>
                <th class="text-nowrap">message</th>
                <th class="text-nowrap">更新时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rows as $row)
                <tr>
                    <td class="text-nowrap">{{ $row->id }}</td>
                    <th class="text-nowrap">{{ $row->video->title }}[{{ $row->video->id }}]</th>
                    <td class="text-nowrap">{{ $row->file_id }}</td>
                    <td class="text-nowrap"><a href="{{route('admin.tasks.show',$row->id)}}"
                                               target="_blank"> {{ $row->task_id }}</a></td>
                    <td class="text-nowrap">{{ $row->code }}</td>
                    <td class="text-nowrap">{{ $row->message }}</td>
                    <td class="text-nowrap">{{ $row->updated_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="clearfix"></div>
    {!! $rows->render() !!}
    <div class="clearfix"></div>
@stop
@section('js')
    <script language="JavaScript">
        $(function () {
            $('#admin_logs_index').addClass("active")
        });
    </script>
@endsection
