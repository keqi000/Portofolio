<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['projects', 'project_categories', 'skill_categories'] as $table) {
            $items = DB::table($table)->orderBy('sort_order')->orderBy('id')->get(['id']);

            foreach ($items as $index => $item) {
                DB::table($table)->where('id', $item->id)->update([
                    'sort_order' => $index + 1,
                ]);
            }
        }
    }

    public function down(): void
    {
        //
    }
};
