<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\UserModel;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = UserModel::all()->sortDesc();
        if(is_null($user)){
            return response()->json(['status' => 0, 'msg'=>'User not found!', 'data'=>null], 404);
        }
        return response()->json(['status' => 1, 'msg' => 'success','data' => UserResource::collection($user)], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users',
            'password' => 'required',
            'phone' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['status'=>2, 'msg'=>$validator->errors(), 'data' => null], 400);
        }
        $user = UserModel::create($request->all());
        return response()->json(['status' => 1, 'msg'=>'success', 'data' => UserResource::collection(UserModel::where(['id' => $user->id])->get())], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = UserModel::where(['id' => $id])->first();
        if(is_null($user)){
            return response()->json(['status' => 0, 'msg'=>'User not found!', 'data'=>null], 404);
        }
        return response()->json(['status' => 1, 'msg'=>'success', 'data'=>[$user->toArray()]], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = UserModel::where(['id' => $id])->first();
        if(is_null($user)){
            return response()->json(['status' => 0, 'msg'=>'User not found!', 'data'=>null], 404);
        }

        $user->update($request->all());

        return response()->json(['status' => 1, 'msg'=>'success', 'data'=>UserResource::collection(UserModel::where(['id' => $id])->get())], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = UserModel::where('id', $id)->first();
        if(is_null($user)){
            return response()->json(['status' => 0, 'msg'=>'User not found!', 'data'=>null], 404);
        }else{
            $user->delete();
        }
        return response()->json(['status' => 1, 'msg'=>'success', 'data' => null], 200);
    }
}
