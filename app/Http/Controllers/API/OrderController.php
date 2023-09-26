<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use APp\Models\MenuList;
use Illuminate\Support\Facades\DB;


class MenuListController extends BaseController
{
    public function getMenu()
    {        
        $menuLists = DB::table('menu_lists')->get();
        return response()->json(['data' => $menuLists]);
    }
}
