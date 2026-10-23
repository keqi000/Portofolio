<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('projects')->update([
            'is_published' => true,
            'is_featured' => true,
        ]);
    }

    public function down(): void
    {
        //
    }
};
