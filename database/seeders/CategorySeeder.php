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
                'code'=>'102',
                'name' => 'Kas & Bank'
            ],
            [
                'code'=>'201',
                'name' => 'Persediaan'
            ],
        ];

        foreach ($datas as $key => $value) {
            try {
                Category::create([
                    'id' => $key += 1,
                    'code' => $value['code'],
                    'name' => $value['name'],
                ]);
            } catch (\Exception $exception) {
                // Do something when the exception is thrown
            }
        }
    }
}
