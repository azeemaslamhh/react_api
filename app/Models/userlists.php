<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userlists extends Model
{
    protected  $table = 'lists';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'group_id', 'list_name', 'status','transectional_flag', 'validation_status', 'no_of_contacts', 'is_valid', 'is_running', 'lookup_cost','lookup_paid', 'validation_flag', 'is_deleted'];
}
