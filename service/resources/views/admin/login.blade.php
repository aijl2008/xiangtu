@extends('layouts.app')
@section('title', '管理员登录')
@section('content')
    <div class="container">
        <div class="col-md-8">
            <form method="POST" action="{{ route('admin.login.do') }}">
                @csrf

                <div class="form-group row">
                    <label for="email"
                           class="col-sm-4 col-form-label text-md-right">电子邮箱</label>

                    <div class="col-md-6">
                        <input id="email" type="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                               name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password"
                           class="col-md-4 col-form-label text-md-right">登录密码</label>

                    <div class="col-md-6">
                        <input id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                               name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            登录
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
