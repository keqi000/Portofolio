<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class SortOrderService
{
    public function move(Builder $orderedItems, Model $item, int $position): void
    {
        DB::transaction(function () use ($orderedItems, $item, $position): void {
            $items = $orderedItems->lockForUpdate()->get();
            $currentIndex = $items->search(fn (Model $orderedItem): bool => $orderedItem->is($item));

            if ($currentIndex === false) {
                throw new RuntimeException('The item to reorder is not present in the ordered list.');
            }

            $position = max(1, min($position, $items->count()));
            $ordered = $items->all();
            $movingItem = array_splice($ordered, $currentIndex, 1)[0];
            array_splice($ordered, $position - 1, 0, [$movingItem]);

            foreach ($ordered as $index => $orderedItem) {
                $sortOrder = $index + 1;
                if ($orderedItem->sort_order !== $sortOrder) {
                    $orderedItem->forceFill(['sort_order' => $sortOrder])->saveQuietly();
                }
            }
        });
    }

    public function normalize(Builder $orderedItems): void
    {
        DB::transaction(function () use ($orderedItems): void {
            foreach ($orderedItems->lockForUpdate()->get() as $index => $item) {
                $sortOrder = $index + 1;
                if ($item->sort_order !== $sortOrder) {
                    $item->forceFill(['sort_order' => $sortOrder])->saveQuietly();
                }
            }
        });
    }
}
