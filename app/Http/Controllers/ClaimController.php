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
            return view('no_item',[
                'uid' => $uid
            ]);
        }
;

        if($result->order->status != 'PAID'){
            return view('no_item',[
                'uid' => $uid
            ]);
        }

        $result->item->photo = json_decode($result->item->photo,true);

        return view('claim',[
            'uid'   => $uid,
            'data'  => $result
        ]);
    }
}