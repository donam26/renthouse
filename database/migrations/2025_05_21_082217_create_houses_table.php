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
            $table->decimal('distance', 10, 2)->nullable(); // Khoảng cách đi bộ
            $table->string('transportation')->nullable(); // Phương tiện đi lại (xe đạp, tàu, ...)
            $table->decimal('rent_price', 15, 2)->nullable(); // Giá thuê (yên/tháng)
            $table->decimal('input_price', 15, 2)->nullable(); // Tiền đầu vào
            $table->enum('house_type', ['1r-1K', '2K-2DK'])->nullable(); // Dạng nhà
            $table->string('image_path')->nullable(); // Đường dẫn ảnh nhà
            $table->string('share_link')->nullable(); // Link share
            $table->string('ga_chinh')->nullable()->comment('Ga chính gần nhà');
            $table->string('ga_ben_canh')->nullable()->comment('Ga bên cạnh gần nhà');
            $table->string('ga_di_tau_toi')->nullable()->comment('Ga đi tàu tới');
            $table->boolean('is_company')->default(false)->comment('Là công ty hay không');
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
