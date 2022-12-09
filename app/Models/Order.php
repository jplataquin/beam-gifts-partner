<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    protected $connection   = 'mysql_beam_client';
    protected $table        = 'orders';
    use HasFactory;

    public function items()
    {
        return $this->hasMany('App\Models\OrderItem','uid','uid');
    }
}
