@extends('layouts.default')
@section('title', '登录')

@section('content')
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>登录</h5>
            </div>
            <div class="panel-body">
                @include('shared._errors')
                {{-- 在前面新增的路由中，有两个路由的命名完全一致，但由于我们在表单中清楚的指明了使用 POST 动作来提交用户的登录信息，因此 Laravel 会自动将该请求映射到会话控制器的 store 动作上。--}}
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="email">邮箱：</label>
                        <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">密码：</label>
                        <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                    </div>

                    <div class="checkbox">
                        <label><input type="checkbox" name="remember"> 记住我</label>
                    </div>

                    <button type="submit" class="btn btn-primary">登录</button>
                </form>

                <hr>

                <p>还没账号？<a href="{{ route('signup') }}">现在注册！</a></p>
            </div>
        </div>
    </div>
@stop