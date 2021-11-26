<?php

namespace App\Imports;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class InventoryImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    use Importable;

    protected $productIds;

    public function __construct()
    {
        $this->productIds = Product::pluck('id', 'sheetId')->toArray();
    }

    public function model(array $row)
    {

        return new Inventory([
            'sheetId'  => $row['id'],
            'product_id' => $this->productIds[$row['product_id']],
            'quantity' => $row['quantity'],
            'color' => $row['color'],
            'size' => $row['size'],
            'weight' => $row['weight'],
            'price_cents' => $row['price_cents'],
            'sale_price_cents' => $row['sale_price_cents'],
            'cost_cents' => $row['cost_cents'],
            'sku' => $row['sku'],
            'length' => $row['length'],
            'width' => $row['width'],
            'height' => $row['height'],
            'note' => $row['note'],
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

}
