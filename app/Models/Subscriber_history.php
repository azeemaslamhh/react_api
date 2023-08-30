<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber_history extends Model
{
    protected  $table = 'subscriber_history';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
