<?php

namespace Database\Seeders;

use App\Models\Parts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partses = [
            [
                'code' => 'P001',
                'name' => 'Brake Pad',
                'stock' => 50,
                'dealer_price' => 200,
                'retail_price' => 250
            ],
            [
                'code' => 'P002',
                'name' => 'Oil Filter',
                'stock' => 30,
                'dealer_price' => 150,
                'retail_price' => 180
            ],
            [
                'code' => 'P003',
                'name' => 'Looking Glass',
                'stock' => 20,
                'dealer_price' => 500,
                'retail_price' => 600
            ],
            [
                'code' => 'P004',
                'name' => 'Air Filter',
                'stock' => 40,
                'dealer_price' => 100,
                'retail_price' => 120
            ],
            [
                'code' => 'P005',
                'name' => 'Spark Plug',
                'stock' => 50,
                'dealer_price' => 80,
                'retail_price' => 100
            ],
        ];

        foreach ($partses as $parts) {
            Parts::create($parts);
        }
    }
}
