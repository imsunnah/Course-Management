<?php

use App\Models\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Module::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('image')->nullable();
            $table->boolean('video_type')->nullable();
            $table->string('video_path')->nullable();
            $table->string('video_link')->nullable();
            $table->text('text')->nullable(); // for text content
            $table->string('length')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
