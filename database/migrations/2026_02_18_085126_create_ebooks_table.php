<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ebooks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->text('description')->nullable();
            $table->string('file_path'); // path ke file PDF/EPUB
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes(); // fitur soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ebooks');
    }
};
