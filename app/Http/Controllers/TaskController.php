<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

class TaskController extends Controller
{
    
    public function index()
    {
        $tasks = Task::where('user_id', Auth::user()->id)->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {

        // dd($request);
        Task::create([
            'name' => $request->name,
            'comment' => $request->comment,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'تم إنشاء المهمة بنجاح!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }

    // ---> Update Status
    public function updateStatus(Request $request, Task $task)
    {
        $task->update($request->only('status'));
        return redirect()->back();
    }


    public function deleteTask(Request $request, $taskId)
    {
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json([
                'message' => 'Task not found',
            ], 404);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ], 200);
    }
}
