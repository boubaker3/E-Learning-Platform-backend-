<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavesModel;
use Illuminate\Support\Facades\DB;

class SavesController extends Controller

{
    
    function createSaveId(){
        $userid="";
        
        for($i=0;$i<=rand(5,20);$i++){
            $userid.=rand(0,9);
        }
        return $userid;
    }
    public function save(Request $request){
        $saves=new SavesModel();
        $saves->insert(["saveid"=>$this->createSaveId(),
                    "userid"=>$request->userid,
                    "courseid"=>$request->courseid,
                    "created_at"=>date("Y-m-d H:i:s"),
                    "updated_at"=>date("Y-m-d H:i:s")]);
        return response()->json(["res"=>"succeed"]); 


    }

    public function showSaves(Request $request){
        $courses=DB::table("saves")->where("saves.userid",$request->userid)
        ->join("courses","courses.courseid","=","saves.courseid")
        ->join("users","users.userid","=","courses.userid")

        ->select("courses.*","users.userid","users.fullname","users.photo" )
        ->offset($skip)
        ->limit($perpage)
        ->get();
    $totalCourses = DB::table('saves')->where("saves.userid",$request->userid)->limit(200)->count();
                  
    return response()->json(["courses"=>$courses,
    "totalCourses" => $totalCourses]);


    }
}
