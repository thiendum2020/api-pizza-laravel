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
        return response()->json(['status' => 1, 'msg' => 'success','data' => UserResource::collection($user)->toArray()]);
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
        // $rules = [
        //     'username' => 'required|min:1',
        //     'password' => 'required|min:1',
        //     'phone' => 'required|max:11',

        // ];
        // $validator = Validator::make($request->all(), $rules);
        // if($validator->fails()){
        //     return response()->json($validator->errors(), 400);
        // }
        $user = UserModel::create($request->all());
        return response()->json(['status' => 1, 'data' => UserResource::collection(UserModel::where(['id' => $user->id])->get())], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = UserModel::where(['id' => $id])->get();
        if(is_null($user)){
            return response()->json(["message"=>"Record not found!"], 404);
        }
        return response()->json(['status' => 1, 'data' => $user], 201);
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
            return response()->json(["message"=>"Record not found!"], 404);
        }
        $user->update($request->all());

        return response()->json(['status' => 1, UserResource::collection(UserModel::where(['id' => $id])->get())], 200);
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
            return response()->json(["message"=>"Record not found!"], 404);
        }else{
            $user->delete();
        }
        return response()->json(['status' => 1, 'data' => null], 404);
    }
}
