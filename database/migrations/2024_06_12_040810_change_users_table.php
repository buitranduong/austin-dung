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
        Schema::table('users', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->longText('head_script_before',)->nullable();
            $table->longText('head_script_after',)->nullable();
            $table->longText('body_script_before',)->nullable();
            $table->longText('body_script_after',)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('head_script_before');
            $table->dropColumn('head_script_after');
            $table->dropColumn('body_script_before');
            $table->dropColumn('body_script_after');
        });
    }
};
