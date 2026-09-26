<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable =
    [
        'name',
        'slug',
        'parent_id',
        'description',
        'art_path'
    ];

    public function category()
    {
        return $this->hasMany(Project::class,'category_id','id');
    }

   public function children()
   {
    return $this->hasMany(Category::class,'parent_id','id');
   }
   public function parent()
   {
        return $this->belongsTo(category::class,'parent_id','id')
        ->withDefault('no parent');
   }

}
