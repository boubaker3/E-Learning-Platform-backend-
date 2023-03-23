<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartModel;
use Illuminate\Support\Facades\DB;
use App\Models\PurshasesModel;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $cart=new CartModel();
        $cart->insert([
            'courseid'=>$request->courseid,
            'userid'=>$request->userid,
            "created_at"=>date("Y-m-d H:i:s"),
            "updated_at"=>date("Y-m-d H:i:s") 
        ]);
       return response()->json(["res"=>"succeed"]);

    }
    public function getCartCourses(Request $request){
        $purshases=new PurshasesModel();
        $data=$purshases->where("userid",$request->userid)->where("courseid",$request->courseid)->get();
        if(!empty($data)){
            return response()->json(["res"=>true]);
        }
        return response()->json(["res"=>false]);

        }
        public function getAddedCartCourses(Request $request){
            $purshased = DB::table('purshases') 
            ->where('userid',  $request->userid)
            ->pluck('courseid')
            ->toArray();
            $cartCourses=DB::table("cart")->where("cart.userid",$request->userid)
            ->whereNotIn("cart.courseid" ,$purshased)
            ->join("courses","cart.courseid","=","courses.courseid")
            ->join("users","users.userid","=","courses.userid")
            ->select( "courses.*","users.fullname","users.photo","users.userid")
            ->get();
        
return response()->json(["cartCourses"=>$cartCourses ]);
            }


        function deleteCartItem(Request $request){
            $cart=new CartModel();

            $cart->where("courseid",$request->courseid)->delete();

            return response()->json(["res"=>"succeed"]);

        }
      
}
