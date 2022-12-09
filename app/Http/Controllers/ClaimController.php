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

        $orderItem = OrderItem::findOrFail($uid);
        
        return view('claim',[
            'uid' => $uid
        ]);
    }
}