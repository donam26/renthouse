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
            $table->string('ga_chinh')->nullable()->after('address')->comment('Ga chính gần nhà');
            $table->string('ga_ben_canh')->nullable()->after('ga_chinh')->comment('Ga bên cạnh gần nhà');
            $table->string('ga_di_tau_toi')->nullable()->after('ga_ben_canh')->comment('Ga đi tàu tới');
            $table->boolean('is_company')->default(false)->after('status')->comment('Là công ty hay không');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('houses', function (Blueprint $table) {
            $table->dropColumn(['ga_chinh', 'ga_ben_canh', 'ga_di_tau_toi', 'is_company']);
        });
    }
};
