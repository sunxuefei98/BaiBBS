<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    //使用 Laravel 提供身份验证（Auth）中间件来过滤未登录用户的 edit, update 动作
    //except意为：除了此处指定的动作以外，所有其他动作都必须登录用户才能访问，类似于黑名单的过滤机制
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    //    增加 show 方法来处理个人页面的展示 (Your Profile)
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    //    增加 edit 方法来处理个人页面的展示 (Setting)
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('user.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id);
            if ($result) {
                $data['avatar'] = $result['path'];
            }else{
                //上传有错误  withErrors可以返回错误提示
                return back()->withErrors(['Supported image formats only include png, jpg, gif and jpeg.']);
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
