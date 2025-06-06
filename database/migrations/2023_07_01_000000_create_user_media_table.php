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
        Schema::create('user_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('media_type', ['video', 'license', 'interaction'])->comment('Loại media: video, giấy phép, ảnh tương tác');
            $table->string('file_path');
            $table->string('title')->nullable()->comment('Tiêu đề của media');
            $table->text('description')->nullable()->comment('Mô tả chi tiết');
            $table->boolean('is_active')->default(true)->comment('Trạng thái kích hoạt hiển thị');
            $table->integer('sort_order')->default(0)->comment('Thứ tự sắp xếp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_media');
    }
}; 