<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;

class UsersController extends Controller
{
    // 注册
    public function create()
    {
        return view('users.create');
    }

    // 显示用户的信息
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // 用户注册
    public function store(Request $request)
    {
        // 验证数据
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        // 创建用户
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // 顶部位置显示注册成功的提示信息
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        // 重定向到个人信息页
        return redirect()->route('users.show', [$user]);
    }
}
