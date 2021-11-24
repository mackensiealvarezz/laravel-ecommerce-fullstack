<?php

namespace Database\Seeders;

use App\Imports\UsersImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new UsersImport, storage_path('app/data/users.csv'));
    }
}
