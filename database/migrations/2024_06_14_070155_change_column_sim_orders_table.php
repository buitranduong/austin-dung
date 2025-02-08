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
        Schema::table('sim_orders', function (Blueprint $table) {
            $table->string('sim', 11)->comment('Số sim đặt mua')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sim_orders', function (Blueprint $table) {
            $table->dropColumn('sim');
        });
    }
};
