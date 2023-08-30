<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedulecampaigns extends Model
{
    protected  $table = 'campaigns_schedule';
    protected $primaryKey = 'id';
    protected $guarded = []; 
}
