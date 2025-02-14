@props(['url'])
<tr>
<td class="header">
<a href="{{ route('login') }}" style="display: inline-block;">
@if (trim($slot) === config('app.name'))
<img src="{{asset('img/logo.png')}}" class="logo" alt="sits Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
