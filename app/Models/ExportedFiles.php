<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportedFiles extends Model
{
     protected $fillable = ['file_path', 'type', 'user_id','download_name','ip_address','status','module_id','params']; 

     ///type = 0 list
     //status = 0 =>
}
