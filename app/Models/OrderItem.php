<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Order;

class OrderItem extends Model
{
    protected $connection   = 'mysql_beam_client';
    protected $table        = 'order_items';
    protected $dates        = ['expires_at'];
    use HasFactory;

    public function order()
    {
        return $this->belongsTo('App\Models\Order','uid','uid');
    }

    public function item(){
        return $this->belongsTo('App\Models\Item','item_id','id');
    }
}
