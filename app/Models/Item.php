<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Item extends Model
{
    protected $connection = 'mysql_beam_admin';
    protected $table = 'items';

    use HasFactory;

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand','brand_id','id');
    }
}
