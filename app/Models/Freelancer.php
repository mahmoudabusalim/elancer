<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'profile_photo_path',
        'discription',
        'gander',
        'birthday',
        'title',
        'hourly_rate',
        'country',

    ];
    protected $casts = [
        'birthday'=> 'date',
        'hourly_rate' => 'float',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
