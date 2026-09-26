<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        
    ];
    public $timestamps = false;
    
    public function projects()
    {
        return $this->belongsToMany(
            Project::class ,
            'project_tag',
            'tag_id',
            'project_id',
            'id',
            'id',
        );
    }

  
}
