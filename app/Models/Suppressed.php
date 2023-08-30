<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suppressed extends Model
{
    protected  $table = 'mobile_suppression';
    protected $primaryKey = 'id';
    protected $guarded = [];    
}
