<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
//    增加 show 方法来处理个人页面的展示
    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }
}
