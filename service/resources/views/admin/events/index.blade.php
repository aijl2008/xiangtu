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
                <th class="text-nowrap">version</th>
                <th class="text-nowrap">type</th>
                <th class="text-nowrap">status</th>
                <th class="text-nowrap">code</th>
                <th class="text-nowrap">message</th>
                <th class="text-nowrap">data</th>
                <th class="text-nowrap">更新时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rows as $row)
                <tr>
                    <td class="text-nowrap">{{ $row->id }}</td>
                    <td class="text-nowrap">{{ $row->version }}</td>
                    <td class="text-nowrap">{{ $row->type }}</td>
                    <td class="text-nowrap">{{ $row->status }}</td>
                    <td class="text-nowrap">{{ $row->code }}</td>
                    <td class="text-nowrap">{{ $row->message }}</td>
                    <td class="text-nowrap">
                        <pre>{{ $row->data }}</pre>
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
            $('#admin_events_index').addClass("active")
        });
    </script>
@endsection
