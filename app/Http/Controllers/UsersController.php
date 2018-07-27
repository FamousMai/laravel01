<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    // 权限控制
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

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

        // 注册成功后，自动登录
        Auth::login($user);

        // 顶部位置显示注册成功的提示信息
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        // 重定向到个人信息页
        return redirect()->route('users.show', [$user]);
    }

    // 显示视图 - 编辑用户
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    // 编辑用户
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }

    // 用户列表
    public function index()
    {
        // paginate 方法来指定每页生成的数据数量为 10 条
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    // 删除用户
    public function destroy(User $user)
    {
        // 使用 authorize 方法来对删除操作进行授权验证
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
}
