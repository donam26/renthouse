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
            // Đổi tên trường house_type thành default_house_type
            $table->renameColumn('house_type', 'default_house_type');
            
            // Thêm các trường house_type cho từng ga và công ty
            $table->enum('ga_chinh_house_type', ['1R-1K', '2K-2DK'])->nullable()->after('ga_chinh');
            $table->enum('ga_ben_canh_house_type', ['1R-1K', '2K-2DK'])->nullable()->after('ga_ben_canh');
            $table->enum('ga_di_tau_toi_house_type', ['1R-1K', '2K-2DK'])->nullable()->after('ga_di_tau_toi');
            $table->enum('company_house_type', ['1R-1K', '2K-2DK'])->nullable()->after('is_company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            // Xóa các trường house_type mới
            $table->dropColumn([
                'ga_chinh_house_type',
                'ga_ben_canh_house_type',
                'ga_di_tau_toi_house_type',
                'company_house_type',
            ]);
            
            // Đổi lại tên trường default_house_type thành house_type
            $table->renameColumn('default_house_type', 'house_type');
        });
    }
};
