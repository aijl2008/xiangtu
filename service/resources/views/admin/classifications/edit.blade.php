@extends('layouts.app')
@section('title', '视频分类管理')

@section('content')
    @include('layouts/message')
    {!! Form::model($row, [
                                'method' => 'PATCH',
                                'route' => ['admin.classifications.update', $row->id],
                                'class' => 'form-horizontal',
                                'files' => true
                            ]) !!}
    {!! Form::input('hidden', 'id') !!}
    @include ('admin.classifications.form', ['submitButtonText' => '更新'])
    {!! Form::close() !!}
@endsection