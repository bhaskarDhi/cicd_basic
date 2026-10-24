<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::where('user_id', $request->user()->id)
            ->orderBy('is_done')
            ->latest()
            ->get();

        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        Task::create([
            'user_id' => $request->user()->id,
            'title' => $data['title'],
        ]);

        return redirect()->route('tasks.index')->with('status', 'Task added.');
    }

    public function toggle(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 403);

        $task->update(['is_done' => ! $task->is_done]);

        return redirect()->route('tasks.index');
    }

    public function destroy(Request $request, Task $task)
    {
        abort_unless($task->user_id === $request->user()->id, 403);

        $task->delete();

        return redirect()->route('tasks.index')->with('status', 'Task deleted.');
    }
}
