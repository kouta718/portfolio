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
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('official_name', 255);
            $table->string('category')->nullable();
            $table->string('image_url')->nullable();
            $table->string('amazon_url')->nullable();
            $table->string('monotaro_url')->nullable();
            $table->text('usage')->nullable();
            $table->text('safety_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
