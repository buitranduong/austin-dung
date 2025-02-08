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
            $table->boolean('error')->default(false)->comment('Error không push lại');
            $table->text('logs')->nullable()->comment('Log trả về từ TOPSIM nếu bị lỗi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sim_orders', function (Blueprint $table) {
            $table->dropColumn('error');
            $table->dropColumn('logs');
        });
    }
};
