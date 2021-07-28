<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    //    增加 show 方法来处理个人页面的展示 (Your Profile)
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    //    增加 edit 方法来处理个人页面的展示 (Setting)
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
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
