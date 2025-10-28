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
    Schema::create('courses', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug')->nullable();
    $table->text('summary')->nullable();
    $table->string('category_id')->nullable();
    $table->string('level')->nullable();
    $table->integer('course_price')->nullable();
    $table->string('feature_video')->nullable();
    $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
