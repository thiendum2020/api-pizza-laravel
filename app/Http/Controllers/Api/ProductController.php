<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\ProductModel;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Get All Product
    public function index()
    {
        $product = ProductModel::all()->sortDesc();
        if(is_null($product)){
            return response()->json(['status' => 0, 'msg'=>'Product not found!', 'data'=>null], 404);
        }
        return response()->json(['status' => 1, 'msg'=>'success', 'data' => ProductResource::collection($product)]);

    }


    public function getProductByTypeId($typeid)
    {
        $product = ProductModel::where(['type_id' => $typeid])->get()->sortDesc();
        if(is_null($product)){
            return response()->json(['status' => 0, 'msg'=>'Product not found!', 'data'=>null], 404);
        }
        return response()->json(['status' => 1, 'msg'=>'success', 'data' => ProductResource::collection($product)]);
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
            'name' => 'required|unique:products',
            'price' => 'required|min:1',
            'type_id' => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json(['status'=>2, 'msg'=>$validator->errors(), 'data' => null], 400);
        }

        $product = ProductModel::create($request->all());
        $file = $request->file('image');
        $resource = fopen($file, "r") or die("File upload Problems");

        //Upload image by API
        //0e0dc4ad07642fa5354c6fe779bc975ae7f08875
        //46dded22984842f
        $imgur_client = new Client(['base_uri' => 'https://api.imgur.com/3/upload']);
        $imgur_response = $imgur_client->post('image', [
            'headers' => [
                'Authorization' => 'Client-ID 46dded22984842f',

            ],
            'multipart' => [
                [
                    'Content-Type' => 'multipart/form-data; boundary=<calculated when request is sent>',
                    'name' => 'image',
                    'contents' => $resource,
                ]
            ]
        ]);
        $img_link = json_decode($imgur_response->getBody())->data->link;

        ProductModel::where(['id' => $product->id])->update(['image' => $img_link]);

        return response()->json(['status' => 1, 'msg'=>'success', 'data' => ProductResource::collection(ProductModel::where(['id' => $product->id])->get())], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $product = ProductModel::where(['id' => $id])->first();
        if(is_null($product)){
            return response()->json(['status' => 0, 'msg'=>'Product not found!', 'data'=>null], 404);
        }
        return response()->json(['status' => 1, 'msg'=>'success', 'data' => [$product->toArray()]], 201);
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
        $product = ProductModel::where(['id' => $id])->first();
        if(is_null($product)){
            return response()->json(['status' => 0, 'msg'=>'Product not found!', 'data'=>null], 404);
        }

        $product->update($request->all());

        return response()->json(['status' => 1, 'msg'=>'success', 'data' =>  ProductResource::collection(ProductModel::where(['id' => $id])->get())], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = ProductModel::where(['id' => $id])->first();
        if(is_null($product)){
            return response()->json(['status' => 0, 'msg'=>'Product not found!', 'data'=>null], 404);
        }
        $product->delete();

        return response()->json(['status' => 1, 'msg'=>'success', 'data' => null], 200);
    }
}
