@if(session()->has('error'))
{{ session('error') }}
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ url('auth/register') }}" method="post">
{{ csrf_field() }}
用户名：<input type="text" name="name"><br /><br />
邮箱：<input type="text" name="email" placeholder="邮箱"><br /><br />
密码：<input type="text" name="password"><br /><br />
<button type="submit">注册</button>
</form>