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
        Schema::table('seo_sims', function (Blueprint $table) {
            $table->integer('sim_type')->nullable()->change();
            $table->unique(['sim_type','price_min','price_max']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seo_sims', function (Blueprint $table) {
            $table->dropColumn('sim_type');
        });
    }
};
