<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            // Xóa một số trường cũ mà sẽ được chuyển sang dạng JSON
            $table->dropColumn([
                'transportation',
                'distance',
            ]);
            
            // Thêm các trường mới
            $table->decimal('size', 8, 2)->after('location')->comment('Diện tích (m2)');
            $table->decimal('initial_cost', 15, 2)->nullable()->after('deposit_price')->comment('Chi phí ban đầu');
            $table->json('room_details')->nullable()->after('description')->comment('Chi tiết phòng: tầng, gác lửng, ga gần nhất');
            $table->json('cost_details')->nullable()->after('room_details')->comment('Chi tiết chi phí: đặt cọc, phí bảo lãnh');
            $table->json('amenities')->nullable()->after('cost_details')->comment('Tiện ích: điều hòa, tủ lạnh');
            
            // Chỉnh sửa trường house_type để chứa nhiều loại hơn
            $table->enum('house_type', ['1K', '2K-2DK'])
                  ->default('1K')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            // Khôi phục các trường cũ
            $table->string('transportation')->nullable();
            $table->decimal('distance', 10, 2)->nullable();
            
            // Xóa các trường mới
            $table->dropColumn([
                'size',
                'initial_cost',
                'room_details',
                'cost_details',
                'amenities',
            ]);
            
            // Khôi phục trường house_type
            $table->enum('house_type', ['1r', '1k', '1DK', '2K', '2DK', '3DK'])
                  ->nullable()
                  ->change();
        });
    }
}; 