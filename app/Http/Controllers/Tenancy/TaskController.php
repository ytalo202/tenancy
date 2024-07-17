<?php

namespace App\Http\Controllers\Tenancy;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tenancy.tasks.index')->with(['tasks' => Task::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenancy.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:tasks',
            'description' => 'required',
            'image_url' => 'required|image',
        ]);

        $data['image_url'] = Storage::put('tasks', $request->file('image_url'));

        $task = Task::create($data);

        return redirect()->route('tasks.index')
            ->with('success', 'Tenant created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('tenancy.tasks.show')->with(['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('tenancy.tasks.edit')->with(['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'name' => 'required|unique:tasks,name,' . $task->id,
            'description' => 'required',
            'image_url' => 'nullable|image',
        ]);

        if ($request->hasFile('image_url')){
            Storage::delete($task->image_url);
            $data['image_url'] = Storage::put('tasks', $request->file('image_url'));
        }
        $task->update($data);


        return redirect()->route('tasks.index')
            ->with('success', 'Tenant created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tenant created successfully');
    }
}
