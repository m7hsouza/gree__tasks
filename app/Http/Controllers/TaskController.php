<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use App\Task;
use App\TaskStages;

class TaskController extends Controller
{
    public function findAllWithAssignees()
    {
        $tasks = Task::with(['assignee:id,name,img', 'stage'])->get();

        return $tasks;
    }

    public function update(Request $request, $taskId)
    {
        $task = Task::find($taskId);
       
        $task->title = $request->title;
        $task->progress = $request->progress;
        $task->stage_id = $request->stageId;

        $task->save();
        $task->load(['assignee:id,name,img', 'stage']);

        return $task;
    }

    public function save(Request $request)
    {   $request->validate([
            'title' => ['required', 'min:8', 'max:255']
        ]);

        $task = new Task;

        $task->title = $request->title;
        $task->user_id = Auth::user()->id;

        $task->save();
        $task->load(['assignee:id,name,img', 'stage']);

        return $task;
    }

    public function delete(Request $request, $taskId)
    {
        $task = Task::find($taskId);

        $isDeleted = $task->delete();

        return ['isDeleted' => $isDeleted];
    }
}
