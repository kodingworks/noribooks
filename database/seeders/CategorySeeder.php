<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
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
                'id' => 1,
                'name' => 'Kas & Bank'
            ],
            [
                'id' => 2,
                'name' => 'Akun Piutang'
            ],
        ];

        foreach ($datas as $data) {
            try {
                Category::create([
                    'name' => $data['name']
                ]);
            } catch (\Exception $exception) {
                // Do something when the exception is thrown
            }
        }
    }
}
