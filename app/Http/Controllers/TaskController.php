<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Tasks/Index', [
            'tasks' => Task::orderBy('name')->get(),
            'statuses' => Status::all()->keyBy('id'),
            'urgentLimit' => config('constants.redColorLimitNumber'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:tasks|max:50',
        ];

        $validated = $request->validate($rules);

        $task = new Task();
        $task->fill($validated);

        $status = Status::where('name', 'regular')->first();

        $status->tasks()->save($task);

        return redirect()
            ->route('tasks.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $rules = [
            'name' => 'max:50',
            'completed' => 'boolean'
        ];

        $validated = $request->validate($rules);

        $task->fill($validated);

        $status = Status::where('id', $request->status_id)->first();
        $task->status()->associate($status);

        $task->save();

        return redirect()
            ->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('message', 'Blog Delete Successfully');
    }
}
