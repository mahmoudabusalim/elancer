<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
// use App\Models\Freelancer;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function freelancer(){
        return $this->hasOne(Freelancer::class,'user_id','id')
        ->withDefault();
    }

    public function projects()
    {
        return $this->hasMany(Project::class,'user_id','id');
    }

    public function getProfilePhotoPathAttribute()
    {
        if($this->freelancer->profile_photo_path){
            return asset('uploads/'.$this->freelancer->profile_photo_path);
        }
        return asset('images/default_photo.jpeg');
    }
        // Accessors
    public function getNameAttribute($value)
    {
        return Str::title($value);
    }
    //Mutators
    public function setEmailAttribute($value)
    {
         $this->attributes['email'] = Str::lower($value);
    }


}
