<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WatchedModel;
use App\Models\CoursesModel;
use Illuminate\Support\Facades\DB;

class WatchedController extends Controller
{
    public function addWatched(Request $request){
        $saves=new WatchedModel();
        $courses=new CoursesModel();
        $Course=$courses->where("courseid",$request->courseid)->first();
        $courses->where("courseid",$request->courseid)->update(["views"=>$course->views+1]);
        $saves->insert([
                    "userid"=>$request->userid,
                    "courseid"=>$request->courseid,
                    "created_at"=>date("Y-m-d H:i:s"),
                    "updated_at"=>date("Y-m-d H:i:s")]);
        return response()->json(["res"=>"succeed"]); 


    }

    public function showWatched(Request $request){
        $perpage=10;
        $skip=$request->page*$perpage-$perpage;
        $courses=DB::table("watched")->where("watched.userid",$request->userid)
        ->join("courses","courses.courseid","=","watched.courseid")
        ->join("users","users.userid","=","courses.userid")
        ->select("courses.*","users.userid","users.fullname","users.photo" )
        ->offset($skip)
        ->limit($perpage)
        ->get();
        $totalCourses = DB::table('watched')->where("watched.userid",$request->userid)->limit(200)->count();
        return response()->json(["courses"=>$courses,
        "totalCourses" => $totalCourses]); 


    }
}
