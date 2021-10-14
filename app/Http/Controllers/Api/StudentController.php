<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    //register Api
    public function register(Request $request){
        //validation
        $request->validate([
            "name"=>"required",
            "email"=>"required|email|unique:students",
            "password"=>"required|confirmed"

        ]);
        //create data
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->phone_no = isset($request->phone_no) ? $request->phone_no : "";
        $student->save();
        //send data
        return  response()->json([
            "status"=>1,
            "message"=>"student registered successfully"

        ]);


    }
    //login Api
    public function login(Request $request){
        //validation
        $request->validate([
            "email"=>"required|email",
            "password"=>"required"
        ]);
        //check student
        $student=Student::where("email","=",$request->email)->first();
        if(isset($student->id)){
            if(Hash::check($request->password,$student->password)){
                //create tokrn
                $token = $student->createToken("auth_token")->plainTextToken;
                //send response
                return response()->json([
                    "stasus"=>1,
                    "message"=>"student logged in successfully",
                    "access_token"=>$token
                ]);

            }
            else{
                return response([
                    "status"=>0,
                    "message"=>"password didn't match"
                ],404);
            }

        }
        else{
            return response([
                "status"=>0,
                "message"=>"student not found"
            ],404);
        }

    }
    //profile Api
    public function profile(){

    }
    //logout profile
    public function logout(){

    }
}
