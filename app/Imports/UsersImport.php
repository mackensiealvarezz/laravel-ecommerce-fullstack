<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow {

    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'sheetId'         => $row['id'],
            'name'            => $row['name'],
            'email'           => $row['email'],
            'password'        => Hash::make($row['password_plain']),
            'shop_name'       => $row['shop_name'],
            'shop_domain'     => $row['shop_domain'],
            'card_brand'      => $row['card_brand'],
            'card_last_four'  => $row['card_last_four'],
            'billing_plan'    => $row['billing_plan'],
            'trial_ends_at'   => $row['trial_ends_at'],
            'trial_starts_at' => $row['trial_starts_at'],
            'superadmin'      => $row['superadmin'],
            'is_enabled'      => $row['is_enabled'],
            'created_at'      => $row['created_at'],
            'updated_at'      => $row['updated_at']
        ]);
    }

}
