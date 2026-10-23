<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        if (Schema::hasTable('projects')) {
            $categories = DB::table('projects')->select('category')->distinct()->pluck('category');
            foreach ($categories as $sortOrder => $name) {
                if ($name) {
                    DB::table('project_categories')->insertOrIgnore([
                        'name' => $name,
                        'sort_order' => $sortOrder + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('project_categories');
    }
};
