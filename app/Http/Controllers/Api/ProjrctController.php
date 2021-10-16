<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Project;


class ProjrctController extends Controller
{
    //create project Api
    public function createProject(Request $request){
        //validation
        $request -> validate([
            "name"=>"required",
            "description"=>"required",
            "duration"=>"required"
        ]);
        //student id + create data
        $student_id = auth()->user()->id;

        $project = new Project();
        $project->student_id = $student_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->duration = $request->duration;

        $project->save();

        //send response
        return response()->json([
           "status"=>1,
           "message"=>"project created successfully",

        ]);



    }
    //list projects Api
    public function listProjects(){
        $student_id = auth()->user()->id;

        $projects = Project::where("student_id",$student_id)->get();

        return response()->json([
           "status"=>1,
           "message"=>"list of projects" ,
            "data"=>$projects
        ]);

    }
    //single project Api
    public function singleProject($id){
        $student_id = auth()->user()->id;
        if(Project::where([
            "id"=>$id,
            "student_id"=>$student_id
        ])->exists()){
            $detail = Project::where([
                "id"=>$id,
                "student_id"=>$student_id
            ])->first();
            return response()->json([
               "status"=>1,
               "message"=>"project details",
               "data"=>$detail
            ]);

        }else{
            return response()->json([
               "status"=>0,
               "message"=>"project not found"
            ]);
        }

    }
    //delete project
    public function deleteProject($id){
        $student_id = auth()->user()->id;
        if(Project::where([
            "id"=>$id,
            "student_id"=>$student_id
        ])->exists()){
            $project = Project::where([
                "id"=>$id,
                "student_id"=>$student_id
            ])->first();
            $project->delete();
            return response()->json([
                "status"=>1,
                "message"=>"project deleted successfully"
            ]);

        } else{
            return response([
               "status"=>0,
               "message"=>"project not found"
            ]);
        }


    }
}
