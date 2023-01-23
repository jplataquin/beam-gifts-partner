<?php
namespace App\Http\Controllers;

use App\Models\PartnerLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogsController extends Controller
{

    public function index(){
        return view('logs');
    }

    public function list(Request $request){

        $user_id = Auth::user()->id;

        $limit      = (int) $request->input('limit') ?? 0;
        $page       = (int) $request->input('page') ?? 0;
        $order      = $request->input('order') ?? 'DESC';

        if($limit > 0){
            $page   = $page * $limit;
        }
        
        $logs = new PartnerLog();

        $result = [];

        $logs = $logs->where('partner_id',$user_id);
        
        if($limit > 0){
            $page   = $page * $limit;
            $result = $logs->skip($page)->take($limit)->orderBy('created_at', $order)->get();
        }else{
            $result = $logs->orderBy('created_at', $order)->get();
        }

        $result = $logs->get();

        for($i = 0; $i <= count($result) - 1; $i++){
            $result[$i]->entry      = json_decode($result[$i]->entry);
        }
        

        return response()->json([
            'status'    => 1,
            'message'   =>'',
            'data'      =>  [
                'items' => $result 
            ]
        ]);
    }
}