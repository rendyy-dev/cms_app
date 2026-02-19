<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('access_type');
            $table->decimal('price', 12, 2)->nullable()->after('whatsapp_number');
        });
    }

    public function down(): void
    {
        Schema::table('ebooks', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_number', 'price']);
        });
    }
};

