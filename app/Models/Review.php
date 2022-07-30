<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at','updated_at'];

    //relations start
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function employee(){
        return $this->belongsTo(User::class,'employee_id');
    }

    public function assignments(){
        return $this->belongsToMany(User::class,'user_reviews');
    }

    public function feedback(){
        return $this->hasMany(Feedback::class);
    }
    //relations end

    // accessors & Mutator start
    public function getReviewAttribute($val){
        return $this->attributes['review'] = ucwords($val);
    }
    // accessors & Mutator end
}
