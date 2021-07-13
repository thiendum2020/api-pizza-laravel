<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Models\BillModel;
use App\Http\Resources\BillResource;
use App\Models\UserModel;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bill = BillModel::all()->sortDesc();
        if(count($bill)==0){
            return response()->json(['status' => 0, 'msg'=>'Bill is empty!', 'data'=>null], 200);
        }
        return response()->json(['status' => 1, 'msg'=>'success', 'data' => BillResource::collection($bill)]);
    }

    public function getBillByUserId($userid)
    {
        $user = UserModel::where(['id' => $userid])->first();
        if(is_null($user)){
            return response()->json(['status' => 0, 'msg'=>'User not found!', 'data'=>null], 404);
        }

        $bill = BillModel::where(['user_id' => $userid])->where('note','<>','created')->get()->sortDesc();
        if(count($bill)==0){
            return response()->json(['status' => 2, 'msg'=>'Bill is empty!', 'data'=>null], 200);
        }
        return response()->json(['status' => 1, 'msg'=>'success', 'data' => BillResource::collection($bill)]);
    }

    public function getBillByNote($note)
    {
        $bill = BillModel::where(['note' => $note])->get()->sortDesc();
        if(count($bill)==0){
            return response()->json(['status' => 2, 'msg'=>'Bill is empty!', 'data'=>null], 200);
        }
        return response()->json(['status' => 1, 'msg'=>'success', 'data' => BillResource::collection($bill)]);
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

        $bill = BillModel::create($request->all());
        return response()->json(['status' => 1, 'msg'=>'success', 'data' => BillResource::collection(BillModel::where(['id' => $bill->id])->get())], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = BillModel::where(['id' => $id])->first();
        if(is_null($bill)){
            return response()->json(['status' => 0, 'msg'=>'Bill not found!', 'data'=>null], 404);
        }
        return response()->json(['status' => 1, 'msg'=>'success', 'data' => $bill->toArray()], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $bill = BillModel::where(['id' => $id])->first();
        if(is_null($bill)){
            return response()->json(['status' => 0, 'msg'=>'Bill not found!', 'data'=>null], 404);
        }
        $bill->update($request->all());

        return response()->json(['status' => 1, 'msg'=>'success', 'data' => BillResource::collection(BillModel::where(['id' => $id])->get())], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill = BillModel::where(['id' => $id])->first();
        if(is_null($bill)){
            return response()->json(['status' => 0, 'msg'=>'Bill not found!', 'data'=>null], 404);
        }
        $bill->delete();

        return response()->json(['status' => 1, 'msg'=>'success', 'data' => null], 200);
    }


}
