<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\CategoryType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('meta_data')->nullable();
            $table->text('related_content')->nullable();
            $table->longText('head_script_before',)->nullable();
            $table->longText('head_script_after',)->nullable();
            $table->longText('body_script_before',)->nullable();
            $table->longText('body_script_after',)->nullable();
            $table->boolean('published')->default(true)->index();
            $table->enum('type', CategoryType::values())->default(CategoryType::Category)->index();
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
