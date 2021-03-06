<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'last_name', 'first_name', 'email', 'password', 'role', 'company'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function video()
    {
        return $this->belongsToMany(Video::class);
    }
    public function watermark()
    {
        return $this->hasMany(Watermark::class);
    }
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
	public function influencer() {
	    return $this->belongsToMany('App\User', 'influencer_sponsor', 'sponsor_id', 'influencer_id');
	}
	
	public function sponsor() {
	    return $this->belongsToMany('App\User', 'influencer_sponsor', 'influencer_id', 'sponsor_id');
	} 
}
