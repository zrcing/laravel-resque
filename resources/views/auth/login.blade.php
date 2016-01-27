@if(session()->has('error'))
{{ session('error') }}
@endif
<form action="{{ url('auth/login') }}" method="post">
{{ csrf_field() }}
<!--  <input type="hidden" name="_token" value="{{ csrf_token() }}" /> -->
<input type="text" name="name">
<input type="text" name="password">
<button type="submit">Login</button>
<a href="{{ url('auth/register') }}"><button type="button">Register</button></a>
</form>