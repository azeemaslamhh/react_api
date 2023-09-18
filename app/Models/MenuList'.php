<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class MenuList extends Model
{

    protected $fillable = ['name', 'slug', 'menu_type_id', 'user_id'];

  
}


