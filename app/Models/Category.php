<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "category";
    protected $fillable = ['id', 'name_ar','name_en','active','created_at','updated_at'];
    protected $hidden = ['created_at','updated_at'];
    public $timestamps = false;

    public function scopeSelection($query){
       return $query -> select('id','name_'.app()->getLocale() .' as name','active');
    }

}
