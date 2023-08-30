<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customlists extends Model
{
    protected  $table = 'list_custom_field';
    protected $primaryKey = 'id';
    protected $guarded = [];
    public $timestamps = false;
}
