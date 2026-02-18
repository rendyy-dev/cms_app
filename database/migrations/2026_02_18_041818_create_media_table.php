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
        Schema::create('media', function (Blueprint $table) {
            $table->id();

            $table->foreignId('album_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('file_path')->nullable(); // bisa null kalau video URL
            $table->string('video_url')->nullable(); // bisa null kalau image
            $table->enum('type', ['image', 'video']);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_featured')->default(false);

            $table->timestamps();

            $table->index('type');
            $table->index('order');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
