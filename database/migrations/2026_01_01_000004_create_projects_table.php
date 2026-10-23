<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('tagline');
            $table->string('category')->default('Full-Stack'); // Full-Stack, Backend / API, Open Source, etc.
            $table->text('problem_statement');
            $table->text('solution_description');
            $table->json('tech_stack'); // Array of string tech badges, e.g. ["Laravel 12", "PostgreSQL", "Tailwind CSS"]
            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('featured_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

