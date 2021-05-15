<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\Http\Requests\CreateTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     *@return フォルダー情報、選択されている$id
     */
    public function index(int $id)
    {
        // すべてのフォルダーを取得する
        $folders = Folder::all();

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

}
