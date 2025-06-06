<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone_number',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Quan hệ User có nhiều House
     */
    public function houses()
    {
        return $this->hasMany(House::class);
    }

    /**
     * Quan hệ User có nhiều UserMedia
     */
    public function media()
    {
        return $this->hasMany(UserMedia::class);
    }

    /**
     * Lấy video của user
     */
    public function videos()
    {
        return $this->media()->where('media_type', 'video')->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Lấy ảnh giấy phép của user
     */
    public function licenses()
    {
        return $this->media()->where('media_type', 'license')->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Lấy ảnh tương tác của user
     */
    public function interactions()
    {
        return $this->media()->where('media_type', 'interaction')->where('is_active', true)->orderBy('sort_order');
    }
}
