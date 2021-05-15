<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
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

}
