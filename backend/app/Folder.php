<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    // TaskController→
    // return tasks()
    // Laravel はフォルダテーブルとタスクテーブルの関連性（リレーション）
    // を「たどって」、フォルダクラスのインスタンスから紐づくタスククラスのリストを取得

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
