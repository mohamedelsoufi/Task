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

    protected $hidden = ['password', 'remember_token',];

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

    // accessors & Mutators statr
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
    // accessors & Mutators end

    //scopes start
    public function scopeAdmin($query){
        return $query->where('is_admin',1);
    }

    public function scopeEmployees($query){
        return $query->where('is_admin',0);
    }
    //scopes end
}
