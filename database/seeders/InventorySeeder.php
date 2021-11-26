<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\InventoryImport;
use Maatwebsite\Excel\Facades\Excel;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new InventoryImport, storage_path('app/data/inventory.csv'));
    }
}
