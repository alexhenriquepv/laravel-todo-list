<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\Image;

use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::withTrashed()->with('images')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $data = $request->all();
        $task = Task::create($data);

        if ($request->image) {
            $storage = Storage::disk('local');
            $extension  = request()->file('image')->getClientOriginalExtension();
            $image_name = time() .'_' . $request->title . '.' . $extension;

            $path = $storage->putFile('tasks-images', $request->image, 'public');
            $task->images()->create(["path" => $path]);
        }

        return response("created", 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Task::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, string $id)
    {
        $task =  Task::findOrFail($id);
        $data = $request->all();

        if ($data["completed"] == TRUE) {
            $data["completed"] = 1;
            $data['completed_at'] = Carbon::now()->toDateTimeString();
        }

        $task->update($data);

        if ($request->image) {
            $storage = Storage::disk('local');
            $extension  = request()->file('image')->getClientOriginalExtension();
            $image_name = time() .'_' . $request->title . '.' . $extension;

            $path = $storage->putFile('tasks-images', $request->image, 'public');
            $task->images()->create(["path" => $path]);
        }

        return response("updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::destroy($id);
        return response("deleted");
    }
}
