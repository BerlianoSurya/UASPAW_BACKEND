<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Komens;
use Illuminate\Validation\Rule;
use Validator;
class KfeedController extends Controller
{
    public function index(){
        $komens = Komens::with('user','feed')->get();
        if(count($komens)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $komens
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }
    
    public function show($id){
        $komen =Komens::where('feedid',$id)->with('user')->get();
        if(!is_null($komen)){
            return response([
                'message' => 'Retrieve Komen Success',
                'data' => $komen
            ],200);
        }
        return response([
            'message' => 'Komen Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request)
    {

        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'komen' => 'required|alpha_num',
            'usersid' => 'required|numeric',
            'feedid' => 'required|numeric',
        ]);
        if($validate->fails()) 
        return response(['message' =>$validate->errors()],400);
        
        $komen =Komens::create($storeData);
        return response([
            'message' => 'Add Komen Success',
            'user' => $komen
        ],200);
    }
    
    public function destroy($id){
        $komen =Komens::find($id);
        if(is_null($komen)){
            return response([
            'message' => 'Komen Not Found',
            'data' => $komen
            ],404);
        }
        if($komen->delete()){
            return response([
                'message' => 'Delete Komen Success',
                'data' => $komen
            ],200);
        }
        return response([
            'message' => 'Delete Komen Failed',
            'data' => null
        ],400);
    }

    public function update(Request $request, $id){
        $komen =Komens::find($id);
        if(is_null($komen)){
            return response([
            'message' => 'Komen Not Found',
            'data' => null
            ],404);
        }

        $updateData=$request->all();
        $validate = Validator::make($updateData, [
            'komen' => 'required',
        ]);
        if($validate->fails()) 
        return response(['message' =>$validate->errors()],400);

        $komen->komen=$updateData['komen'];
        if($komen->save()){
            return response([
                'message' => 'Update Komen Success',
                'data' => $komen
            ],200);
        }
        
        return response([
            'message' => 'Update Komen Failed',
            'data' => null
        ],400);
    }
}
