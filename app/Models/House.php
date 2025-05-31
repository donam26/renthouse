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
        'ga_chinh',
        'ga_chinh_house_type',
        'ga_ben_canh',
        'ga_ben_canh_house_type',
        'ga_di_tau_toi',
        'ga_di_tau_toi_house_type',
        'rent_price',
        'input_price',
        'default_house_type',
        'is_company',
        'company_house_type',
        'image_path',
        'share_link',
        'description',
        'transportation',
        'distance',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rent_price' => 'decimal:2',
        'input_price' => 'decimal:2',
        'is_company' => 'boolean',
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
