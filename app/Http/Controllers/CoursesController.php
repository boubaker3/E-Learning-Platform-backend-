<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 use App\Models\CoursesModel;
 use App\Models\VideosModel;
 use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{
    function createCourseId(){
        $userid="";
        
        for($i=0;$i<=rand(5,20);$i++){
            $userid.=rand(0,9);
        }
        return $userid;
    }

    function sharecourse(Request $request){
        $courseId=$this->createCourseId();

        if($request->hasFile('thumb')){
            $thumb = $request->file('thumb');
            $thumbName = $thumb->getClientOriginalName();
            $thumb->move(public_path('thumbs'), $thumbName);
            $courses=new CoursesModel([
            'userid'=>$request->userid,
            'courseid'=>$courseId,
            'title'=>$request->title,
            'description'=>$request->description,
            'category'=>$request->category,
            'requirements'=> $request->requirements ,
            'paid_or_free'=>$request->paid_or_free,
            'price'=>$request->price,
            'thumb'=>"thumbs/".uniqid().$thumbName,
            "created_at"=>date("Y-m-d H:i:s"),
            "updated_at"=>date("Y-m-d H:i:s") 
        ]);
             $courses->save(); 
        $videos = $request->file('videos');
        foreach ($videos as $video) {
            $videoName = $video->getClientOriginalName();
            $video->move(public_path('videos'), $videoName);
            $videosModel=new VideosModel([
                'courseid'=>$courseId,
                'videoid'=>$this->createCourseId(),
                'title'=>pathinfo($videoName, PATHINFO_FILENAME),
                'path'=>"videos/".uniqid().$videoName,
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s") 
            ]);
        $videosModel->save();
        }
        return response()->json(["res"=>"succeed"]);

    }else{
        return response()->json(["res"=>"no files found"]);

    }
    
}



      function getRecommendedCourses(Request $request){
      }

}
