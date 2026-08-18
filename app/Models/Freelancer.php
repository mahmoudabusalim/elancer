<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'discription',
        'gander',
        'birthday',
        'title',
        'hourly_rate',
        'country',

    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
