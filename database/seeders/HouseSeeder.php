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
            'name' => 'Căn hộ 1K tầng 2 có gác lửng 12.5m²',
            'address' => '神奈川県川崎市川崎区田町2-5-16',
            'location' => 'Kanagawa',
            'size' => 12.5,
            'rent_price' => 58000,
            'deposit_price' => 58000,
            'initial_cost' => 85000,
            'house_type' => '1K',
            'status' => 'available',
            'description' => 'Căn hộ 1K có gác lửng, tầng 2, gần ga Kojima Shinden. Đầy đủ tiện nghi cơ bản.',
            'share_link' => 'house_kawasaki',
            'room_details' => [
                'floor' => 2,
                'has_loft' => true,
                'nearest_station' => 'Kojima Shinden',
                'distance_to_station' => null,
            ],
            'cost_details' => [
                'deposit' => 58000,
                'key_money' => null,
                'guarantee_fee' => 10000,
                'insurance_fee' => 10000,
                'document_fee' => 7000,
                'parking_fee' => null,
                'rent_included' => true,
            ],
            'amenities' => [
                'air_conditioner' => true,
                'refrigerator' => false,
                'washing_machine' => false,
                'internet' => true,
                'furniture' => false,
            ],
        ]);
        
        // Nhà 2: Saitama
        $house2 = House::create([
            'user_id' => $user->id,
            'name' => 'Căn hộ 1K tầng 1 rộng rãi 20m²',
            'address' => '埼玉県南埼玉郡宮代町大字須賀1884番地39',
            'location' => 'Saitama',
            'size' => 20.0,
            'rent_price' => 41000,
            'deposit_price' => 41000,
            'initial_cost' => 140000,
            'house_type' => '1K',
            'status' => 'available',
            'description' => 'Căn hộ 1K rộng rãi 20m², tầng 1, cách ga Tobu Dobutsu Koen 10 phút đi bộ. Có bãi đậu xe.',
            'share_link' => 'house_saitama',
            'room_details' => [
                'floor' => 1,
                'has_loft' => false,
                'nearest_station' => 'Tobu Dobutsu Koen',
                'distance_to_station' => 10,
            ],
            'cost_details' => [
                'deposit' => 41000,
                'key_money' => null,
                'guarantee_fee' => 30000,
                'insurance_fee' => 50000,
                'document_fee' => 19000,
                'parking_fee' => 2000,
                'rent_included' => true,
            ],
            'amenities' => [
                'air_conditioner' => true,
                'refrigerator' => true,
                'washing_machine' => false,
                'internet' => true,
                'furniture' => false,
            ],
        ]);
        
        // Nhà 3: Tokyo
        $house3 = House::create([
            'user_id' => $user->id,
            'name' => 'Căn hộ 1K tầng 3 có gác lửng 14m²',
            'address' => '東京都大田区西蒲田3丁目5-4',
            'location' => 'Tokyo',
            'size' => 14.0,
            'rent_price' => 67000,
            'deposit_price' => 67000,
            'initial_cost' => 220000,
            'house_type' => '1K',
            'status' => 'available',
            'description' => 'Căn hộ 1K có gác lửng, tầng 3, cách ga Ikegami 8 phút đi bộ. Khu vực an ninh tốt, gần nhiều tiện ích.',
            'share_link' => 'house_tokyo',
            'room_details' => [
                'floor' => 3,
                'has_loft' => true,
                'nearest_station' => 'Ikegami',
                'distance_to_station' => 8,
            ],
            'cost_details' => [
                'deposit' => 67000,
                'key_money' => 67000,
                'guarantee_fee' => 30000,
                'insurance_fee' => 36000,
                'document_fee' => 20000,
                'parking_fee' => null,
                'rent_included' => true,
            ],
            'amenities' => [
                'air_conditioner' => true,
                'refrigerator' => true,
                'washing_machine' => true,
                'internet' => true,
                'furniture' => true,
            ],
        ]);
        
        // Tạo ảnh mẫu cho các nhà (chỉ giả định, cần tạo ảnh thật)
        $this->createSampleImages($house1);
        $this->createSampleImages($house2);
        $this->createSampleImages($house3);
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