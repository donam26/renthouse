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
        'size',
        'rent_price',
        'deposit_price',
        'initial_cost',
        'house_type',
        'status',
        'description',
        'image_path',
        'share_link',
        'room_details',
        'cost_details',
        'amenities',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rent_price' => 'decimal:2',
        'deposit_price' => 'decimal:2',
        'initial_cost' => 'decimal:2',
        'size' => 'decimal:2',
        'room_details' => 'array',
        'cost_details' => 'array',
        'amenities' => 'array',
    ];

    /**
     * Các trường chi tiết phòng mặc định
     */
    public function getDefaultRoomDetails()
    {
        return [
            'floor' => null,
            'has_loft' => false,
            'nearest_station' => null,
            'distance_to_station' => null,
            'transportation' => null,
        ];
    }

    /**
     * Các trường chi tiết chi phí mặc định
     */
    public function getDefaultCostDetails()
    {
        return [
            'deposit' => null,
            'key_money' => null,
            'guarantee_fee' => null,
            'insurance_fee' => null,
            'document_fee' => null,
            'parking_fee' => null,
            'rent_included' => true,
        ];
    }

    /**
     * Các tiện ích mặc định
     */
    public function getDefaultAmenities()
    {
        return [
            'air_conditioner' => false,
            'refrigerator' => false,
            'washing_machine' => false,
            'internet' => false,
            'furniture' => false,
        ];
    }

    /**
     * Khởi tạo các trường JSON với giá trị mặc định nếu chưa có
     */
    public function initializeJsonFields()
    {
        if (empty($this->room_details)) {
            $this->room_details = $this->getDefaultRoomDetails();
        }
        
        if (empty($this->cost_details)) {
            $this->cost_details = $this->getDefaultCostDetails();
        }
        
        if (empty($this->amenities)) {
            $this->amenities = $this->getDefaultAmenities();
        }
    }
    
    /**
     * Lấy tầng của căn hộ từ room_details
     */
    public function getFloorAttribute()
    {
        return $this->room_details['floor'] ?? null;
    }
    
    /**
     * Kiểm tra căn hộ có gác lửng không từ room_details
     */
    public function getHasLoftAttribute()
    {
        return $this->room_details['has_loft'] ?? false;
    }
    
    /**
     * Lấy ga gần nhất từ room_details
     */
    public function getNearestStationAttribute()
    {
        return $this->room_details['nearest_station'] ?? null;
    }
    
    /**
     * Lấy khoảng cách đến ga từ room_details
     */
    public function getDistanceToStationAttribute()
    {
        return $this->room_details['distance_to_station'] ?? null;
    }
    
    /**
     * Lấy phí đỗ xe từ cost_details
     */
    public function getParkingFeeAttribute()
    {
        return $this->cost_details['parking_fee'] ?? null;
    }

    /**
     * Lấy phương tiện di chuyển từ room_details
     */
    public function getTransportationAttribute()
    {
        return $this->room_details['transportation'] ?? null;
    }

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
