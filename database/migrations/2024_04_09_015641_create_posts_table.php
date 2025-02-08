<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\PostType;
use App\Enums\PostStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('featured_image')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('sticky')->default(false);
            $table->enum('status', PostStatus::values())->default(PostStatus::Draft);
            $table->enum('type', PostType::values())->default(PostType::Post);
            $table->json('meta_data')->nullable();
            $table->text('related_content')->nullable();
            $table->longText('head_script_before',)->nullable();
            $table->longText('head_script_after',)->nullable();
            $table->longText('body_script_before',)->nullable();
            $table->longText('body_script_after',)->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['sticky','status','type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
