<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
    public function login(Request $request) {
        $user = UserModel::where(['username' => $request->get('username')])->first();

        if($user == null)
            return response()->json(['status' => 0, 'msg' => 'Username does not exist','data'=>null], 404);

        else {
            if($user->password != $request->get('password'))
                return response()->json(['status' => 2, 'msg' => 'Password is incorrect','data'=>null], 400);
            else
                return response()->json(['status' => 0, 'msg'=>'success', 'data' => $user]);
        }
    }
}
