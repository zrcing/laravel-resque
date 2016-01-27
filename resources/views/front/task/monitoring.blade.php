<p>


@foreach($tasks as $task)

{{ $task->task_name }}

@endforeach

{!! $links !!}

</p>

<p>
<a href="{{ url('auth/logout') }}">Logout</a>
</p>