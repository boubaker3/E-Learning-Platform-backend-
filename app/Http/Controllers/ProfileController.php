<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersModel;
class ProfileController extends Controller
{
    public function getUserData(Request $request){
        $usersModel=new UsersModel();
        $userdata=$usersModel->where("userid",$request->userid)->first();
        return response()->json(["userdata"=>$userdata]);
    }
}
