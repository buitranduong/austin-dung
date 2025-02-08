<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PageStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seo_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('h2')->nullable();
            $table->string('featured_image')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('featured')->default(false);
            $table->enum('status', PageStatus::values())->default(PageStatus::Published);
            $table->timestamp('published_at')->nullable();
            $table->json('meta_data')->nullable();
            $table->text('related_content')->nullable();
            $table->longText('head_script_before',)->nullable();
            $table->longText('head_script_after',)->nullable();
            $table->longText('body_script_before',)->nullable();
            $table->longText('body_script_after',)->nullable();
            $table->json('sim_setting')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();

            $table->index(['featured','status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_pages');
    }
};
