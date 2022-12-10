<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{   
    protected $connection = 'mysql_beam_admin';
    protected $table = 'brands';
    use HasFactory;

    public function items(){
        return $this->hasMany('App\Models\Items','brand_id','id');
    }
    
}
