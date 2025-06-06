<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMedia extends Model
{
    use HasFactory;

    /**
     * Các thuộc tính có thể gán hàng loạt
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'media_type',
        'file_path',
        'title',
        'description',
        'is_active',
        'sort_order',
    ];

    /**
     * Các thuộc tính cần cast
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Quan hệ với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope để lấy video
     */
    public function scopeVideos($query)
    {
        return $query->where('media_type', 'video')->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Scope để lấy ảnh giấy phép
     */
    public function scopeLicenses($query)
    {
        return $query->where('media_type', 'license')->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Scope để lấy ảnh tương tác
     */
    public function scopeInteractions($query)
    {
        return $query->where('media_type', 'interaction')->where('is_active', true)->orderBy('sort_order');
    }
} 