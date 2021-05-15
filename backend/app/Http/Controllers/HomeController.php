<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // ログイン画面のコントローラー
    public function index()
    {
        // ログインユーザーを取得する
        $user = Auth::user();

        // ログインユーザーに紐づくフォルダーを一つ取得する
        $folder = $user->folders()->first();

        // まだ一つもフォルダを作っていない場合はホームぺージへレスポンスする
        if (is_null($folder)) {
            return view('home');
        }

        // フォルダがあれば、そのフォルダの一覧へリダイレクト
        return redirect()->route('tasks.index',[
            'id' => $folder->id,
        ]);
    }
}
