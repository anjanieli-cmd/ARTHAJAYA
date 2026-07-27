<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type');           // contoh: 'new_user', 'new_company'
            $table->string('title');
            $table->text('message');
            $table->string('icon')->default('inbox'); // nama ikon: bell, inbox, users, building, dst
            $table->string('url')->nullable();          // link tujuan saat notifikasi diklik
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};