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
        Schema::create('seo_sims', function (Blueprint $table) {
            $table->id();
            $table->integer('sim_type')->nullable()->index();
            $table->unsignedBigInteger('price_min')->default(0);
            $table->unsignedBigInteger('price_max')->nullable();
            $table->string('title')->nullable();
            $table->string('h1')->nullable();
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_sims');
    }
};
