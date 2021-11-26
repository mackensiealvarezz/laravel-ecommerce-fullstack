<?php

namespace Database\Seeders;

use App\Imports\OrdersImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new OrdersImport, storage_path('app/data/orders.csv'));
    }
}
