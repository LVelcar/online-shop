<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin_since',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
     protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'admin_since' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function payments(){
        return $this->hasManyThrough(Payment::class, Order::class, 'customer_id', 'order_id');
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function isAdmin()
    {
        return $this->admin_since !== null 
            && $this->admin_since->lessThanOrEqualTo(now());
    }

}
