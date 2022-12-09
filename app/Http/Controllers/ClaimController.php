<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;

class ClaimController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    public function index($uid){

        $orderItem = new OrderItem;

        $result = $orderItem->where('item_uid','=',$uid)->first();

        if(!$result){
            return abort(404);
        }

        
        return view('claim',[
            'uid' => $uid
        ]);
    }
}