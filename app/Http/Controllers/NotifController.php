<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifController extends Controller
{
    function showNotifications(Request $request){
        $perpage=10;
        $skip=$request->page*$perpage-$perpage;
          $notifications=DB::table("notifications")->where("notifications.receiverid",$request->userid)
                            ->join("users","users.userid","=","notifications.senderid")
                            ->join("ratings","ratings.senderid","=","notifications.senderid")
                            ->select("notifications.*","users.userid","users.fullname","users.photo","ratings.rating")
                            ->offset($skip)
                            ->limit($perpage)
                            ->get();
        $totalNotifs = DB::table('notifications')->where("notifications.receiverid",$request->userid)->limit(200)->count();
                        
        return response()->json(["notifications"=>$notifications,
   'totalNotifs'=> $totalNotifs]);
    }
}
