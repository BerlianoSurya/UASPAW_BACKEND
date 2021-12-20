<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Market;
use Illuminate\Validation\Rule;
use Validator;

class MarketController extends Controller
{
    public function index(){
        $markets = Market::with('user')->get();
        if(count($markets)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $markets
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }
    
    public function show($id){
        $market =Market::find($id);
        if(!is_null($market)){
            return response([
                'message' => 'Retrieve Market Success',
                'data' => $market
            ],200);
        }
        return response([
            'message' => 'Market Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_barang' => 'required',
            'harga' => 'required',
            'deskripsi'=> 'required',
            'path_barang' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'usersid' => 'required|numeric',
        ]);
        if($validate->fails()) 
        return response(['message' =>$validate->errors()],400);
        $data = new Market;
        if(empty($request->file('path'))){
            $data->nama_barang=$request->nama_barang;
            $data->deskripsi=$request->deskripsi;
            $data->harga=$request->harga;
            $data->usersid=$request->usersid;
            $data->path_barang='kosong.jpg';
            $data ->save();
            return response([
                'message' => 'Add Market Success',
                'data' => $data
            ],200);
        }else{
            $data->nama_barang=$request->caption;
            $data->deskripsi=$request->deskripsi;
            $data->harga=$request->harga;
            $data->usersid=$request->usersid;
            $img_name =  $request->file('path_barang')->getClientOriginalName();
            $request->path_barang->move(public_path('/img/public/'), $img_name);
            $data->path_barang = '/img/public/' . $img_name;
            $data ->save();
            return response([
                'message' => 'Add Market Success',
                'data' => $data
            ],200);
        }
    }
    
    public function destroy($id){
        $market =Market::find($id);
        if(is_null($market)){
            return response([
            'message' => 'Market Not Found',
            'data' => $market
            ],404);
        }
        if($market->delete()){
            return response([
                'message' => 'Delete Market Success',
                'data' => $market
            ],200);
        }
        return response([
            'message' => 'Delete Market Failed',
            'data' => null
        ],400);
    }

    public function update(Request $request, $id){
        $data =Market::find($id);
        if(is_null($data)){
            return response([
            'message' => 'Market Not Found',
            'data' => null
            ],404);
        }

        
        $datafeed=$request->all();
        $validate = Validator::make($datafeed, [
            'nama_barang' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'path_barang' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'usersid' => 'required|numeric',
        ]);
        if($validate->fails()) 
        return response(['message' =>$validate->errors()],400);
        if(empty($request->file('path'))){
            $data->nama_barang=$datafeed['nama_barang'];
            $data->deskripsi=$datafeed['deskripsi'];
            $data->harga=$datafeed['harga'];
            $data->usersid=$request->usersid;
            $data->path_barang='kosong.jpg';
            $data->save();
            return response([
                'message' => 'Edit Market Success',
                'data' => $data
            ],200);
        }else{
            $data->caption=$datafeed['caption'];
            $data->deskripsi=$datafeed['deskripsi'];
            $data->usersid=$request->usersid;
            $data->harga=$datafeed['harga'];
            $img_name =  $request->file('path_barang')->getClientOriginalName();
            $request->path_barang->move(public_path('/img/public/'), $img_name);
            $data->path_barang = '/img/public/' . $img_name;
            $data ->save();
            return response([
                'message' => 'Edit Market Success',
                'data' => $data
            ],200);
        }
    }
}
