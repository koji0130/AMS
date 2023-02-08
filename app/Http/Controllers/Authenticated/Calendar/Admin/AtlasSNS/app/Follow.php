<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    //フォローしているか
    public function isFollowing(Int $user_id)
    {
        return (bool) $this->follows()->where('followed_id', $user_id)->first();
    }

    //フォローされているか
    public function isFollowed(Int $user_id)
    {
        return (bool) $this->follows()->where('following_id', $user_id)->first();
    }
}
