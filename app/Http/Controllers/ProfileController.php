<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersModel;

class ProfileController extends Controller
{
    public function getUserData(Request $request){
        $usersModel=new UsersModel();
        $userdata=$usersModel->where("userid",$request->userid)->first();
        $userdata->photo=addslashes($userdata->photo);
        return response()->json(["userdata"=>$userdata]);
    }
    
  
     public function updatePhoto(Request $request){
        $usersModel=new UsersModel();
        $photo=$request->file('photo');
        $photoname=uniqid().$photo->getClientOriginalName();
        $photo->move(public_path("photos"), $photoname);
        $data=["photo"=> $photoname];
         $usersModel->where("userid",$request->userid)->update($data) ;
        $user=$usersModel->where("userid",$request->userid)->first() ;
        return response()->json(["user"=>$user]);
    }
   
   
   
}
