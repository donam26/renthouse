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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('location')->nullable(); // VD Tokyo, OSAKA, etc.
            $table->decimal('distance', 10, 2)->nullable(); // Khoảng cách đi bộ
            $table->string('transportation')->nullable(); // Phương tiện đi lại (xe đạp, tàu, ...)
            $table->decimal('rent_price', 15, 2)->nullable(); // Giá thuê (yên/tháng)
            $table->decimal('deposit_price', 15, 2)->nullable(); // Tiền đặt cọc
            $table->enum('house_type', ['1K', '2K-2DK'])->nullable(); // Dạng nhà
            $table->enum('status', ['available', 'rented'])->default('available'); // Tình trạng (còn trống/đã thuê)
            $table->text('description')->nullable(); // Mô tả ngắn
            $table->string('image_path')->nullable(); // Đường dẫn ảnh nhà
            $table->string('share_link')->nullable(); // Link share
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
