<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Product;
use App\Imports\UsersImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductsImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{

    protected $userIds;

    public function __construct()
    {
        $this->userIds = User::pluck('id', 'sheetId')->toArray();
    }

    public function model(array $row)
    {
        return new Product([
            'sheetId'  => $row['id'],
            'admin_id' => $this->userIds[$row['admin_id']],
            'name' => $row['product_name'],
            'description' => $row['description'],
            'style' => $row['style'],
            'brand' => $row['brand'],
            'type' => $row['product_type'],
            'url' => $row['url'],
            'shipping_price' => $row['shipping_price'],
            'note' => $row['note'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
        ]);

        // $products = [];
        // foreach ($rows as $row)
        // {
        //     //Find product admin
        //     $excelUserEmail = $userCollection->where('id', $row['admin_id'])->first();
        //     $adminUserId = User::select('id')->where('email', $excelUserEmail['email'])->first();

        //     $products[] = [
        //         'admin_id' => $adminUserId,
        //         'name' => $row['product_name'],
        //         'description' => $row['description'],
        //         'style' => $row['style'],
        //         'brand' => $row['brand'],
        //         'type' => $row['product_type'],
        //         'url' => $row['url'],
        //         'shipping_price' => $row['shipping_price'],
        //         'note' => $row['note'],
        //         'created_at' => $row['created_at'],
        //         'updated_at' => $row['updated_at'],
        //     ];
        // }

        // Product::insert($products);
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
