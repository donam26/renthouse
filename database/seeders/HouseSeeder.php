<?php

namespace Database\Seeders;

use App\Models\House;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa ảnh cũ trong storage trước khi tạo mới
        Storage::disk('public')->deleteDirectory('houses');
        Storage::disk('public')->makeDirectory('houses');
        
        // Lấy user đầu tiên
        $user = User::first();
        
        if (!$user) {
            $user = User::factory()->create([
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@example.com',
                'is_admin' => true,
            ]);
        }
        
        // Tạo dữ liệu nhà mẫu
        $this->createHouseData($user);
    }
    
    /**
     * Tạo dữ liệu mẫu
     */
    private function createHouseData($user)
    {
        // Nhà 1: Kawasaki
        $house1 = House::create([
            'user_id' => $user->id,
            'rent_price' => 58000,
            'input_price' => 58000,
            'house_type' => '1r-1K',
            'share_link' => 'house_kawasaki',
           
        ]);
        
        // Tạo ảnh mẫu cho các nhà (chỉ giả định, cần tạo ảnh thật)
        $this->createSampleImages($house1);
    }
    
    /**
     * Tạo ảnh mẫu cho nhà
     */
    private function createSampleImages($house)
    {
        // Tạo các bản ghi ảnh (không có file thật)
        $house->images()->create([
            'image_path' => 'houses/sample_' . $house->id . '_1.jpg',
            'is_primary' => true,
            'sort_order' => -1,
        ]);
        
        $house->images()->create([
            'image_path' => 'houses/sample_' . $house->id . '_2.jpg',
            'is_primary' => false,
            'sort_order' => 1,
        ]);
    }
} 