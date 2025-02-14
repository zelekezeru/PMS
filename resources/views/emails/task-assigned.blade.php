@component('mail::message')
# Task Assigned

You have been assigned to a new task: {{ $task->title }}

Description: {{ $task->description }}

@component('mail::button', ['url' => route('tasks.show', $task->id)])
View Task
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
