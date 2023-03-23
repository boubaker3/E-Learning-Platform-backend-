<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
 use App\Models\CoursesModel;
 use App\Models\VideosModel;
 use App\Models\UsersModel;
 use App\Models\NotifModel;
 use App\Models\PurshasesModel;
 use App\Models\SavesModel;
 use App\Models\CartModel;
 use App\Models\WatchedModel;
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
            $thumbName = uniqid().$thumb->getClientOriginalName();
            $thumb->move(public_path('thumbs'),$thumbName);
            $courses=new CoursesModel([
            'userid'=>$request->userid,
            'courseid'=>$courseId,
            'title'=>$request->title,
            'description'=>$request->description,
            'category'=>$request->category,
            'requirements'=> $request->requirements ,
            'benefits'=> $request->benefits ,
            'paid_or_free'=>$request->paid_or_free,
            'price'=>$request->price,
            'thumb'=>$thumbName,
            "created_at"=>date("Y-m-d H:i:s"),
            "updated_at"=>date("Y-m-d H:i:s") 
        ]);
             $courses->save(); 
        $videos = $request->file('videos');
        foreach ($videos as $video) {
            $videoPath = uniqid().$video->getClientOriginalName();
            $videoName = $video->getClientOriginalName();
            $video->move(public_path('videos'), $videoName);
            $videosModel=new VideosModel([
                'courseid'=>$courseId,
                'videoid'=>$this->createCourseId(),
                'title'=>pathinfo($videoName, PATHINFO_FILENAME),
                'path'=> $videoPath,
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s") 
            ]);
        $videosModel->save();
        }

        
        $notif=new NotifModel();
        $notif->insert(["notifid"=>$this->createCourseId(),
        "senderid"=>$request->userid,
        "receiverid"=>$courseId,
        "type"=>"share",
        "seen"=>"0",
        "created_at"=>date("Y-m-d H:i:s"),
        "updated_at"=>date("Y-m-d H:i:s")]);


        return response()->json(["res"=>"succeed"]);

    }else{
        return response()->json(["res"=>"no files found"]);

    }
    
}



public function getProfileCourses(Request $request){
    $perpage=10;
    $skip=$request->page*$perpage-$perpage;
    $courses=DB::table("courses")->where("courses.userid",$request->userid)
                        ->join("users","users.userid","=","courses.userid")
                        ->select("users.*","courses.*")
                        ->offset($skip)
                        ->limit($perpage)
                        ->get();
    $totalCourses = DB::table('courses')->where("courses.userid",$request->userid)->limit(200)->count();
                  
    return response()->json(["courses"=>$courses,
    "totalCourses" => $totalCourses]);
}

public function getCourseDetails(Request $request){
    $videos=DB::table("videos")->where("videos.courseid",$request->courseid)
                                        ->get();
    
    $courseDetails=DB::table("courses")->where("courseid",$request->courseid)
    ->first();
    $ratings=DB::table("ratings")->where("ratings.courseid",$request->courseid)
                                    ->join("users","users.userid","=","ratings.senderid")
                                    ->select("ratings.*","users.*")
                                    ->get();

    return response()->json(["videos"=>$videos,"courseDetails"=>$courseDetails,"ratings"=>$ratings]);


}
public function viewVideo(Request $request )
{
    $videosModel =new VideosModel();
    $video=$videosModel->where('videoid', $request->videoid)->firstOrFail();
    $path = public_path('videos/' . $video->path);

    // Check if the file exists
    if (!file_exists($path)) {
        abort(404);
    }

    // Define the start and end byte range for the video
    $start = 0;
    $end = filesize($path) - 1;

    // Set the content type and headers
    $headers = [
        'Content-Type' => 'video/mp4',
        'Content-Length' => $end - $start + 1,
        'Accept-Ranges' => 'bytes',
        'Content-Range' => sprintf('bytes %d-%d/%d', $start, $end, filesize($path)),
        'Cache-Control' => 'no-cache',
    ];

    // Open the file stream and send the response
    $stream = function () use ($path, $start, $end) {
        $file = fopen($path, 'rb');
        fseek($file, $start);

        while (!feof($file) && ftell($file) <= $end) {
            echo fread($file, 1024 * 8);
            flush();
        }

        fclose($file);
    };

    return response()->stream($stream, 206, $headers);
}
 
 
    public function search(Request $request){
        if($request->has('searchfor')){
            $query =$request->searchfor ;
            $courses=DB::table("courses")->where('title', 'like','%'.$query.'%') 
            ->join("users","users.userid","=","courses.userid")
            ->select("users.*","courses.*")
            ->offset($skip)
            ->limit($perpage)
            ->get();
            $totalCourses = DB::table('courses')->where('title', 'like','%'.$query.'%')->limit(200)->count();
        return response()->json(["courses"=> $courses,
        "totalCourses" => $totalCourses]);
        }
       
    
        }

      public function getMyCourses(Request $request) {
        $perpage=10;
        $skip=$request->page*$perpage-$perpage;
        $courses=DB::table("purshases")->where('purshases.userid',$request->userid) 
        ->join("courses","courses.courseid","=","purshases.courseid")
        ->join("users","users.userid","=","courses.userid")
        ->select("users.*","courses.*")
        ->offset($skip)
        ->limit($perpage)
        ->get();
        $totalCourses = DB::table('courses')->limit(200)->count();
    return response()->json(["courses"=> $courses,
    "totalCourses" => $totalCourses]);
      }

   
    function recommendedCourses(Request $request ) {
        $perpage=10;
        $skip=$request->page*$perpage-$perpage;
        $userId=$request->userid;
        $userPurchases = PurshasesModel::where('userid', $userId)->pluck('courseid')->toArray();
        $userCart = CartModel::where('userid', $userId)->pluck('courseid')->toArray();
        $userSaves = SavesModel::where('userid', $userId)->pluck('courseid')->toArray();
        $userWatched = WatchedModel::where('userid', $userId)->pluck('courseid')->toArray();
        $userInterests=array_merge($userPurchases,$userCart,$userSaves,$userWatched);
        $similarUsers=PurshasesModel::whereIn("courseid",$userInterests)
                                    ->where('userid', '!=', $userId)
                                    ->pluck("userid")->toArray();
        $relatedCourses = PurshasesModel::whereIn('userid', $similarUsers)
            ->groupBy('courseid')
            ->orderByRaw('COUNT(*) DESC')
            ->pluck('courseid')
            ->toArray();
      
        $diffCourses = array_diff($relatedCourses, $userInterests); 
        if(empty($diffCourses)||$userId==null){
            $mostWatchedAndRatedCourses = DB::table('courses')
            ->select('courses.title','courses.courseid','courses.thumb',
            'courses.rating','courses.price','users.fullname' ,'users.photo' ,'users.userid' ,
             DB::raw('COUNT(ratings.courseid) as rating_count'))
            ->leftJoin('ratings', 'courses.courseid', '=', 'ratings.courseid')
            ->join('users','users.userid','courses.userid')
            ->groupBy('courses.title','courses.courseid','courses.thumb',
            'courses.rating','courses.price','users.fullname' ,'users.photo' ,'users.userid' )
            ->orderBy('rating_count', 'desc')
            ->orderBy('courses.rating', 'desc')
            ->orderBy('courses.views', 'desc')
            ->offset($skip)
            ->limit($perpage)
            ->get();
            $totalCourses = DB::table('courses')->limit(200)->count();

            return response()->json(["recommendedCourses"=> $mostWatchedAndRatedCourses,
             "totalCourses" => $totalCourses]);

        }
         $recommendedCourses=CoursesModel::whereIn('courseid', $diffCourses)
        ->join("users","users.userid","=","courses.userid")
        ->select("users.*","courses.*")
        ->offset($skip)
        ->limit($perpage)
        ->get();
         return response()->json(["recommendedCourses"=> $recommendedCourses, "totalCourses" => $totalCourses]);

    }
    
     
}      
