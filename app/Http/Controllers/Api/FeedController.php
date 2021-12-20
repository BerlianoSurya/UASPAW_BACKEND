<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Feed;

class FeedController extends Controller
{
    public function index(){
        $feeds = Feed::with('user')->get();
        if(count($feeds)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $feeds
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }
    
    public function show($id){
        $feed =Feed::find($id);
        if(!is_null($feed)){
            return response([
                'message' => 'Retrieve Feed Success',
                'data' => $feed
            ],200);
        }
        return response([
            'message' => 'Feed Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'caption' => 'required',
            'path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'usersid' => 'required|numeric',
        ]);
        if($validate->fails()) 
        return response(['message' =>$validate->errors()],400);
        $data = new Feed;
        if(empty($request->file('path'))){
            $data->caption=$request->caption;
            $data->usersid=$request->usersid;
            $data->path='kosong.jpg';
            $data ->save();
            return response([
                'message' => 'Add Feed Success',
                'data' => $data
            ],200);
        }else{
            $data->caption=$request->caption;
            $data->usersid=$request->usersid;
            $img_name =  $request->file('path')->getClientOriginalName();
            $request->path->move(public_path('assets/images/'), $img_name);
            $data->path = 'assets/images/' . $img_name;
            $data ->save();
            return response([
                'message' => 'Add Feed Success',
                'data' => $data
            ],200);
        }
    }
    
    public function destroy($id){
        $feed =Feed::find($id);
        if(is_null($feed)){
            return response([
            'message' => 'Feed Not Found',
            'data' => $feed
            ],404);
        }
        if($feed->delete()){
            return response([
                'message' => 'Delete Feed Success',
                'data' => $feed
            ],200);
        }
        return response([
            'message' => 'Delete Feed Failed',
            'data' => null
        ],400);
    }

    public function update(Request $request, $id){
        $data =Feed::find($id);
        if(is_null($data)){
            return response([
            'message' => 'Feed Not Found',
            'data' => null
            ],404);
        }

        
        $datafeed=$request->all();
        $validate = Validator::make($datafeed, [
            'caption' => 'required',
            'path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'usersid' => 'required|numeric',
        ]);
        if($validate->fails()) 
        return response(['message' =>$validate->errors()],400);
        if(empty($request->file('path'))){
            $data->caption=$datafeed['caption'];
            $data->path=$data->path;
            $data->save();
            return response([
                'message' => 'Edit Feed Success',
                'data' => $data
            ],200);
        }else{
            $data->caption=$datafeed['caption'];
            $img_name =  $datafeed->file('path')->getClientOriginalName();
            $request->path->move(public_path('/img/public/'), $img_name);
            $data->path = '/img/public/' . $img_name;
            $data->save();
            return response([
                'message' => 'Edit Feed Success',
                'data' => $data
            ],200);
        }
    }
}
