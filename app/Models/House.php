<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'location',
        'distance',
        'transportation',
        'rent_price',
        'deposit_price',
        'house_type',
        'status',
        'description',
        'image_path',
        'share_link',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rent_price' => 'decimal:2',
        'deposit_price' => 'decimal:2',
        'distance' => 'decimal:2',
    ];

    /**
     * Quan hệ House thuộc về một User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ House có nhiều HouseImage
     */
    public function images()
    {
        return $this->hasMany(HouseImage::class)->orderBy('sort_order');
    }

    /**
     * Lấy ảnh chính của nhà
     */
    public function primaryImage()
    {
        return $this->hasOne(HouseImage::class)->where('is_primary', true);
    }
}
