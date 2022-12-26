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

            $uid        = $request->input('uid');
            $screen_h   = $request->input('screen_h');
            $screen_w   = $request->input('screen_w');
            $d_uid      = $request->input('d_uid');
            
            $os         = $this->getUserOS();
            $browser    = $this->getUserBrowser();
            $ip         = $this->getIP();

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
            
            $now        = Carbon::now();
            $expires_at = Carbon::createFromFormat('Y-m-d H:i:s', $result->expires_at);

            //Expiration
            if($expires_at->lte($now)){
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Item has already expired',
                    'data'      => []
                ]);
            }

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
                'os'            => $os,
                'browser'       => $browser,
                'screen_width'  => $screen_w,
                'screen_height' => $screen_h,
                'device_uid'    => $d_uid,
                'ip'            => $ip,
                'date_time'     => $now->format('Y-m-d h:m:s')
            ];

            $logs['entries'][] = $entry;

            $result->logs   = $logs;
            $result->status = 'CLMD'; 

            //Create Partner Log
            $partnerLog = new PartnerLog;

            $partnerLog->status         = 'CLMD';
            $partnerLog->order_item_id  = $result->id;
            $partnerLog->amount         = $result->price;
            $partnerLog->entry          = json_encode($entry);
            $partnerLog->partner_id     = $partner_id;

            
            //Save to database
            DB::beginTransaction();
            
            try{

                $result->save();
                $partnerLog->save();

                DB::commit();

            }catch(Exception $e){

                DB::rollback();

                return response()->json([
                    'status' => 0,
                    'message'=> 'Unable to update records',
                    'data'=> []
                ]);

            }
                
            return response()->json([
                'status' => 1,
                'message'=> '',
                'data'=> []
            ]);

       
    }

    private function getUserOS(){

        $u_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $operating_system = 'Unknown Operating System';
    
        //Get the operating_system name
        if($u_agent) {
            if (preg_match('/linux/i', $u_agent)) {
                $operating_system = 'Linux';
            } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
                $operating_system = 'Mac';
            } elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
                $operating_system = 'Windows';
            } elseif (preg_match('/ubuntu/i', $u_agent)) {
                $operating_system = 'Ubuntu';
            } elseif (preg_match('/iphone/i', $u_agent)) {
                $operating_system = 'IPhone';
            } elseif (preg_match('/ipod/i', $u_agent)) {
                $operating_system = 'IPod';
            } elseif (preg_match('/ipad/i', $u_agent)) {
                $operating_system = 'IPad';
            } elseif (preg_match('/android/i', $u_agent)) {
                $operating_system = 'Android';
            } elseif (preg_match('/blackberry/i', $u_agent)) {
                $operating_system = 'Blackberry';
            } elseif (preg_match('/webos/i', $u_agent)) {
                $operating_system = 'Mobile';
            }
        }
        
        return $operating_system;
    }

    private function getUserBrowser(){
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser        = "Unknown Browser";
        $browser_array  = array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/edge/i'       =>  'Edge',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Handheld Browser'
        );

        foreach ( $browser_array as $regex => $value ) { 
            if ( preg_match( $regex, $user_agent ) ) {
                $browser = $value;
            }
        }

        return $browser;
    }

    private function getIP(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
}