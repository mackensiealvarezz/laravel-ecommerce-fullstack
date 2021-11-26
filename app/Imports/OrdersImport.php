<?php

namespace App\Imports;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class OrdersImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    use Importable;


    protected $productIds;
    protected $inventoryIds;

    public function __construct()
    {
        $this->productIds   = Product::pluck('id', 'sheetId')->toArray();
        $this->inventoryIds = Inventory::pluck('id', 'sheetId')->toArray();
    }

    public function model(array $row)
    {
        return new Order([
            'sheetId'  => $row['id'],
            'product_id' => $this->productIds[$row['product_id']],
            'inventory_id' => $this->inventoryIds[$row['inventory_id']],
            'street_address' => $row['street_address'],
            'apartment' => ($row['apartment'] != 'NULL' ? $row['apartment'] : null),
            'city' => ($row['city'] != 'NULL' ? $row['city'] : null),
            'state' => $row['state'],
            'country_code' => $row['country_code'],
            'zip' => $row['zip'],
            'email' => $row['email'],
            'name' => $row['name'],
            'order_status' => $row['order_status'],
            'payment_ref' => ($row['payment_ref'] != 'NULL' ? $row['payment_ref'] : null),
            'transaction_id' => ($row['transaction_id'] != 'NULL' ? $row['transaction_id'] : null),
            'payment_amt_cents' => $row['payment_amt_cents'],
            'ship_charged_cents' => ($row['ship_charged_cents'] != 'NULL' ? $row['ship_charged_cents'] : null),
            'ship_cost_cents' => ($row['ship_cost_cents'] != 'NULL' ? $row['ship_cost_cents'] : null),
            'subtotal_cents' => $row['subtotal_cents'],
            'total_cents' => $row['total_cents'],
            'shipper_name' => $row['shipper_name'],
            'payment_date' => $row['payment_date'],
            'shipped_date' => $row['shipped_date'],
            'tracking_number' => $row['tracking_number'],
            'tax_total_cents' => $row['tax_total_cents'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
