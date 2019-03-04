<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user){
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user, ImageUploadHandler $uploader)
    {
        $data = $request->all();

        if ($request->avatar){
            $result = $uploader->save($request->avatar, 'avatars', $user->id);
            if ($result){
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('user.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
