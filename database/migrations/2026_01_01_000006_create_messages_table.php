<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name');
            $table->string('sender_email');
            $table->string('subject');
            $table->text('message_body');
            $table->string('ip_address', 45)->nullable();
            $table->boolean('is_read')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};

