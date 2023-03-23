<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubsModel;
use App\Models\NotifModel;
use Illuminate\Support\Facades\DB;

class SubsController extends Controller
{
    function createNotifId(){
        $userid="";
        
        for($i=0;$i<=rand(5,20);$i++){
            $userid.=rand(0,9);
        }
        return $userid;
    }
    public function follow(Request $request){
        $subs=new SubsModel();
        $notif=new NotifModel();
        $res=$subs->where("followerid",$request->senderid)->where("followingid",$request->receiverid)
           ->get();
        if(!empty($res)){
            $subs->where("followerid",$request->senderid)->where("followingid",$request->receiverid)
            ->delete();
return response()->json(["res"=>"succeed"]); 

        }else{

            $subs->insert(["followerid"=>$request->senderid,
            "followingid"=>$request->receiverid,
            "created_at"=>date("Y-m-d H:i:s"),
            "updated_at"=>date("Y-m-d H:i:s")]);

$notif->insert(["notifid"=>$this->createNotifId(),
"senderid"=>$request->senderid,
"receiverid"=>$request->receiverid,
"type"=>"follow",
"seen"=>"0",
"created_at"=>date("Y-m-d H:i:s"),
"updated_at"=>date("Y-m-d H:i:s")]);

return response()->json(["res"=>"succeed"]); 
        }


        }

        public function followed(Request $request){
            $subs=new SubsModel();
           $res=$subs->where("followerid",$request->senderid)->where("followingid",$request->receiverid)
           ->get();
           if(count($res)==0){
            return response()->json(["res"=>false]);

           }
            return response()->json(["res"=>true]);
        }


        function getFollowingCourses(Request $request){
            $courses=DB::table("subscriptions")->where("subscriptions.followerid",$request->userid)
                                ->join("users","users.userid","=","subscriptions.followingid")
                                ->join("courses","courses.userid","=","users.userid")
                                ->select("courses.*","users.userid","users.fullname","users.photo" )
                                ->offset($skip)
                                ->limit($perpage)
                                ->get();
            $totalCourses = DB::table('subscriptions')->where("subscriptions.followerid",$request->userid)->limit(200)->count();
                          
            return response()->json(["courses"=>$courses,
            "totalCourses" => $totalCourses]);
        }
}
