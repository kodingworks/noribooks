<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'code' => '1-10',
                'name' => 'Kas',
                'category' => 'Kas & Bank',
                'type' => 'Debit',
                'description' => 'Tes'

            ],
            [
                'code' => '1-10',
                'name' => 'Piutang Usaha',
                'category' => 'Akun Piutang',
                'type' => 'Debit',
                'description' => 'Tes'

            ],
        ];

        foreach ($datas as $key => $value) {
            try {
                Account::create([
                    'id' => $key += 1,
                    'name' => $value['name'],
                    'category' => $value['category'],
                    'type' => $value['type'],
                    'description' => $value['description'],
                ]);
            } catch (\Exception $exception) {
                // Do something when the exception is thrown
            }
        }
    }
    
}
