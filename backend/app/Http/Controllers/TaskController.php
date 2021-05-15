<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     *@return フォルダー情報、選択されている$id
     */
    public function index(int $id)
    {
        // ユーザーのフォルダを取得する
        $folders = Auth::user()->folders()->get();

        // 選ばれたフォルダを取得する
        $current_folder = Folder::find($id);

        // 選ばれたフォルダに紐づくタスクを取得する
        $tasks = $current_folder->tasks()->get(); //Folder.phpのtasks()メソッドを使用

        return view('tasks/index',[
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);

    }

    /**
    * 新規タスクの作成メソッド
    * GET /folders/{id}/tasks/create
    */
    public function showCreateForm(int $id) 
    {
        return view('tasks/create', [
            'folder_id' => $id
        ]);
    }

    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;
        // $current_folderと紐づくタスクを作成
        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    /**
    * GET /folders/{id}/tasks/{tasks_id}/edit
    * タスクの編集画面 
    */
    public function showEditForm(int $id, int $task_id)
    {
        $task = Task::find($task_id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }

    public function edit(int $id, int $task_id, EditTask $request)
    {
        // タスク情報を取得
        $task = Task::find($task_id);

        // データベースへ挿入
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        // tasks.indexへ返す
        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);

    }
}
