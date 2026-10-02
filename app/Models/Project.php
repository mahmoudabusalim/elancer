<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
class Project extends Model
{
    protected $fillable = [
        'user_id',  
        'category_id',  
        'title',
        'description',
        'status',
        'type',
        'budget',
        'attachments',
        
    ];
    protected $casts = [
    'attachments' => 'json',
];
    const TYPE_FIXED = 'fixed';
    const TYPE_HOURLY = 'hourly';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function category()
    {
     return $this->belongsTo(Category::class,'category_id','id')
     ->withDefault( 'no category' );
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class ,    //Realted model
            'project_tag',  //pivot table
            'project_id',   //F.k. for current model in pivot table
            'tag_id',       //F.K. for related model in pivot table
            'id',           //current model key (p.k.)
            'id',           //related model key (p.k. related model)
        );

    }

    public static function types()
    {
        return [
            self::TYPE_FIXED => 'Fixed',
            self::TYPE_HOURLY => 'Hourly',
        ];
    }

      public function syncTags(array $tags)
    {
        $tags_id = [];
        foreach($tags as $tag_name):
            $tag = Tag::firstOrCreate(
                [
                    'slug'=>Str::slug($tag_name),
                    ],
                [
                    'name'=> trim($tag_name),
                ]);
            $tags_id[] = $tag->id;

        endforeach;

        $this->tags()->sync($tags_id);
    }
}
