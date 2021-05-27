<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Models\BillDetailModel;
use App\Http\Resources\BillDetailResource;

class BillDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $bill_detail = BillDetailModel::all();
        // return response()->json(['status' => 1, 'data' => BillDetailResource::collection($bill_detail)]);
    }

    public function getDetailBillByBillId($billid)
    {
        $bill_detail = BillDetailModel::where(['bill_id' => $billid])->get()->sortDesc();

        return response()->json(['status' => 1, 'data' => BillDetailResource::collection($bill_detail)]);
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
        $bill_detail = BillDetailModel::create($request->all());

        return response()->json(['status' => 1, 'data' => BillDetailResource::collection(BillDetailModel::where(['id' => $bill_detail->id])->get())], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
        $bill_detail = BillDetailModel::where(['id' => $id]);
        if(is_null($bill_detail)){
            return response()->json(["message"=>"Record not found!"], 404);
        }
        $bill_detail->update($request->all());

        return response()->json(['status' => 1, 'data' => BillDetailResource::collection(BillDetailModel::where(['id' => $id])->get())], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill_detail = BillDetailModel::where(['id' => $id])->first();
        if(is_null($bill_detail)){
            return response()->json(["message"=>"Record not found!"], 404);
        }
        $bill_detail->delete();

        return response()->json(['status' => 1, 'data' => null], 404);
    }
 
}
