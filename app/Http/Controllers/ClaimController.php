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

        echo $result->status;exit;
        if($result->status != 'PAID'){
            return view('no_item',[
                'uid' => $uid
            ]);
        }

        $result->photo = json_decode($result->photo,true);

        print_r($result->photo);

        return view('claim',[
            'uid'   => $uid,
            'data'  => $result
        ]);
    }
}