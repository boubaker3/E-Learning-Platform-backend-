<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RatingModel;
use App\Models\CoursesModel;
use Illuminate\Support\Facades\DB;
use App\Models\NotifModel;

class RatingController extends Controller
{
    function createRatingId(){
        $userid="";
        
        for($i=0;$i<=rand(5,20);$i++){
            $userid.=rand(0,9);
        }
        return $userid;
    }
  
    public function postReview(Request $request){
        $rating=new RatingModel();
        $rating->insert(['ratingid'=>$this->createRatingId(),
                        'senderid'=>$request->senderid,
                        'courseid'=>$request->courseid,
                        'review'=>$request->review,
                        'rating'=>$request->rating,
                        "created_at"=>date("Y-m-d H:i:s"),
                           "updated_at"=>date("Y-m-d H:i:s") ]
                    );


        $course=new CoursesModel();

        $where="";
        switch($request->rating){
        case 1:
        $where="oneStar";
        break;
        case 2:
        $where="twoStars";
        break;
        case 3:
        $where="threeStars";
        break;
        case 4:
        $where="fourStars";
        break;
        case 5:
        $where="fiveStars";
        break;
                        
        }
        $ratingData=$course->where("courseid",$request->courseid)->value($where);
        $updateStars=[$where=>$ratingData+=1];
        $course->where("courseid",$request->courseid)->update($updateStars);
        $coursedata=$course->where("courseid",$request->courseid)->first();
        $score=$coursedata->fiveStars*5+$coursedata->fourStars*4+$coursedata->threeStars*3+$coursedata->twoStars*2+$coursedata->oneStar*1;
        $response= $coursedata->fiveStars+$coursedata->fourStars+$coursedata->threeStars+$coursedata->twoStars+$coursedata->oneStar;
        $newRating=$score/$response;
        $rating=["rating"=>$newRating];
        $course->where("courseid",$request->courseid)->update($rating);
                   

        $notif=new NotifModel();
        $notif->insert(["notifid"=>$this->createRatingId(),
        "senderid"=>$request->senderid,
        "receiverid"=>$request->receiverid,
        "type"=>"rating",
        "seen"=>"0",
        "created_at"=>date("Y-m-d H:i:s"),
        "updated_at"=>date("Y-m-d H:i:s")]);


        return response()->json(["res"=>"succeed"]);
    }
    public function showReviews(Request $request){
        $reviews=DB::table("ratings")->where("ratings.courseid",$request->courseid)
        ->join("users","users.userid","=","ratings.senderid")
        ->select("users.fullname","users.photo","ratings.*")
        ->get();
        return response()->json(["reviews"=>$reviews]);
    }
}
