<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime',];

    // JWT auth start
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // JWT auth end

    //relations start
    public function reviews(){
        return $this->hasMany(Review::class,'user_id');
    }

    public function assignments(){
        return $this->belongsToMany(Review::class,'user_reviews');
    }


    //relations end

    // accessors & Mutator start
    public function setPasswordAttribute($val){
        $this->attributes['password'] = bcrypt($val);
    }

    public function getNameAttribute($val){
        return $this->attributes['name'] = ucwords($val);
    }

    public function getImageAttribute($val)
    {
        return asset('uploads') . '/' . $val;
    }
    // accessors & Mutator end

    //scopes start
    public function scopeAdmin($query){
        return $query->where('is_admin',1);
    }

    public function scopeEmployee($query){
        return $query->where('is_admin',0);
    }

    public function scopeEmployees($query){
        return $query->where('is_admin',0);
    }

    public function scopeSearch($query)
    {
        $query->where(function ($q) {
            if (request()->filled('is_admin')) {
                $q->where('is_admin', request()->is_admin);
            }
        })->when(request()->name, function ($q) {
            $q->where('name', 'like', '%' . request()->name . '%');
        })->when(request()->email, function ($q) {
            $q->where('email', 'like', '%' . request()->email . '%');
        });
    }
    //scopes end
}
