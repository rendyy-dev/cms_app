<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {

            $table->string('slug')->unique()->after('title');

            $table->string('cover_path')->nullable()->after('description');

            // free = bisa download tanpa login
            // login = harus login dulu
            $table->enum('access_type', ['free', 'login'])
                  ->default('free')
                  ->after('file_path');

            $table->unsignedBigInteger('download_count')
                  ->default(0)
                  ->after('access_type');

            $table->boolean('is_featured')
                  ->default(false)
                  ->after('download_count');

            $table->index('slug');
            $table->index('access_type');
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {

            $table->dropIndex(['slug']);
            $table->dropIndex(['access_type']);
            $table->dropIndex(['is_featured']);

            $table->dropColumn([
                'slug',
                'cover_path',
                'access_type',
                'download_count',
                'is_featured'
            ]);
        });
    }
};

