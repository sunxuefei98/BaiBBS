<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

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

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', 'Your profile updated successfully!');
    }
}
