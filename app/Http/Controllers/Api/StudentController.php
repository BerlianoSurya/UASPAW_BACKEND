<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Student;
class StudentController extends Controller
{
    public function index(){
        $students =Student::all();
        if(count($students)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $students
            ],200);
        }
        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }
    
    public function show($id){
        $student =Student::find($id);
        if(!is_null($student)){
            return response([
                'message' => 'Retrieve Student Success',
                'data' => $student
            ],200);
        }
        return response([
            'message' => 'Student Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_murid' => 'required|max:60|alpha|unique:students',
            'npm' => 'required|numeric',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'no_telp' => 'required|regex:/(08)[0-9]/|max:13'
        ]);
        if($validate->fails()) 
        return response(['message' =>$validate->errors()],400);

        
        $student =Student::create($storeData);
        return response([
            'message' => 'Add Student Success',
            'user' => $student
        ],200);
    }
    
    public function destroy($id){
        $student =Student::find($id);
        if(is_null($student)){
            return response([
            'message' => 'Student Not Found',
            'data' => $student
            ],404);
        }
        if($student->delete()){
            return response([
                'message' => 'Delete Student Success',
                'data' => $student
            ],200);
        }
        return response([
            'message' => 'Delete Student Failed',
            'data' => null
        ],400);
    }

    public function update(Request $request, $id){
        $student =Student::find($id);
        if(is_null($student)){
            return response([
            'message' => 'Student Not Found',
            'data' => null
            ],404);
        }

        $updateData=$request->all();
        $validate = Validator::make($updateData, [
            'nama_murid' => ['required','max:60','alpha',Rule::unique('students')->ignore($student)],
            'npm' => 'required|numeric',
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'no_telp' => 'required|regex:/(08)[0-9]/|max:13'
        ]);
        if($validate->fails()) 
        return response(['message' =>$validate->errors()],400);

        $student->nama_murid=$updateData['nama_murid'];
        $student->npm=$updateData['npm'];
        $student->tanggal_lahir=$updateData['tanggal_lahir'];
        $student->no_telp=$updateData['no_telp'];
        if($student->save()){
            return response([
                'message' => 'Update Student Success',
                'data' => $student
            ],200);
        }
        
        return response([
            'message' => 'Update Student Failed',
            'data' => null
        ],400);
    }
}
