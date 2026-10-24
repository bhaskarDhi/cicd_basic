@extends('layout')

@section('title', 'My tasks')

@section('content')
<div class="card">
    <h1>My tasks</h1>

    @if (session('status'))
        <div class="status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('tasks.store') }}" class="row">
        @csrf
        <input type="text" name="title" placeholder="What needs to be done?" required>
        <button type="submit">Add</button>
    </form>
    @error('title') <div class="error">{{ $message }}</div> @enderror

    <ul>
        @forelse ($tasks as $task)
            <li class="{{ $task->is_done ? 'done' : '' }}">
                <form class="inline" method="POST" action="{{ route('tasks.toggle', $task) }}">
                    @csrf @method('PATCH')
                    <button class="small" type="submit">{{ $task->is_done ? 'Undo' : 'Done' }}</button>
                </form>
                <span>{{ $task->title }}</span>
                <form class="inline" method="POST" action="{{ route('tasks.destroy', $task) }}">
                    @csrf @method('DELETE')
                    <button class="small danger" type="submit">Delete</button>
                </form>
            </li>
        @empty
            <li class="muted">No tasks yet. Add one above.</li>
        @endforelse
    </ul>
</div>
@endsection
