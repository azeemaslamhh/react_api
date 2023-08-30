<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    protected  $table = 'mobile_subscribers';
    protected $primaryKey = 'id';
    protected $guarded = [];
    ///public $timestamps = false;
    
    function get_files($path, $depth) {
        $str = '';
        $files = scandir($path);
        $spacing = '';
        for ($i = 0; $i < $depth; $i++)
            $spacing .= '&nbsp;';

        foreach ($files as $file) {
            if ($file != 'temp' && $file != '.' && $file != '..') {
                if (is_dir($path . "/" . $file)) {
                    $str .= " <optgroup label='" . $spacing . $spacing . "$file' > ";
                    $str .= $this->get_files($path . "/" . $file, $depth + 1);
                } else
                    $str .= " <option value='" . $file. "'>" . $spacing . " $file </option> ";
            }
        }
        return $str;
    }
    function get_suppress_files($path, $depth) {
        $str = '';
        $files = scandir($path);
        $spacing = '';
        for ($i = 0; $i < $depth; $i++)
            $spacing .= '&nbsp;';

        foreach ($files as $file) {
            if ($file != 'temp' && $file != '.' && $file != '..') {
                if (is_dir($path . "/" . $file)) {
                    $str .= " <optgroup label='" . $spacing . $spacing . "$file' > ";
                    $str .= $this->get_files($path . "/" . $file, $depth + 1);
                } else
                    $str .= " <option value='" . $file . "'>" . $spacing . " $file </option> ";
            }
        }
        return $str;
    }
    function get_imported_files($path, $depth) { //die($path);
        $str = '';
        $files = scandir($path);
        $spacing = '';
        for ($i = 0; $i < $depth; $i++)
            $spacing .= '&nbsp;';

        foreach ($files as $file) {
            if ($file != 'temp' && $file != '.' && $file != '..' && $file != 'dublicate_contacts_list' && $file != 'invalid_contacts_list') {
                if (is_dir($path . "/" . $file)) {
                    $str .= " <optgroup label='" . $spacing . $spacing . "$file' > ";
                    $str .= $this->get_files($path . "/" . $file, $depth + 1);
                } else
                    $str .= " <option value='" . $file . "'>" . $spacing . " $file </option> ";
            }
        }
        
        return $str;
    }
}
