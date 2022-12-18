<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderItem;
use App\Models\PartnerLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

        if(trim($uid) == ''){
            return view('no_item',[
                'uid' => $uid
            ]);
        }

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
            'data'  => $result,
            'status' => $result->order->status
        ]);
    }

    public function claim(Request $request){

        DB::transaction(function (){

            $uid = $request->input('uid');

            if($uid == ''){
                return response()->json([
                    'status' => 0,
                    'message'=> 'Item not found',
                    'data'=> []
                ]);
            }

            $orderItem = new OrderItem;

            $result = $orderItem->where('item_uid','=',$uid)->first();

            if(!$result){
                return response()->json([
                    'status' => 0,
                    'message'=> 'Item not found',
                    'data'=> []
                ]);
            }
    ;

            if($result->order->status != 'PAID'){
                return response()->json([
                    'status' => 0,
                    'message'=> 'This item has invalid status',
                    'data'=> []
                ]);
            }

            if($result->consumed >= $result->quantity){
                return response()->json([
                    'status' => 0,
                    'message'=> 'Total item quantity is already consumed',
                    'data'=> []
                ]);
            }

            //Expiration

            $result->consumed = $result->consumed + 1;

            $logs = json_decode($result->logs,true);

            if(!isset($logs['entries'])){
                $logs['entries'] = [];
            }

            $partner_id = Auth::user()->id;

            $entry = [
                'action'        => 'Claimed',
                'by'            => $partner_id,
                'item_name'     => $result->item_name,
                'brand_name'    => $result->brand_name,
                'value'         => $result->price,
                'consumed'      => $result->consumed,
                'quantity'      => $result->quantity,
                'date_time'     => Carbon::now()->format('Y-m-d h:m:s')
            ];

            $logs['entries'][] = $entry;

            $result->logs = $logs;


            //Create Partner Log
            $partnerLog = new ParnterLog();

            $partnerLog->satus          = 'CLAI';
            $partnerLog->order_item_id  = $result->id;
            $partnerLog->amount         = $result->price;
            $partnerLog->entry          = $entry;
            $parnterLog->partner_id     = $partner_id;

            //Save to database
            $result->save();
            $parnterLog->save();

            return response()->json([
                'status' => 1,
                'message'=> '',
                'data'=> []
            ]);

        });
    }
}