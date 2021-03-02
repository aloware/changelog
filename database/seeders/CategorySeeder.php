<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'label' => 'New',
                'created_at' => Carbon::now()
            ],
            [
                'label' => 'Improvement',
                'created_at' => Carbon::now()
            ],
            [
                'label' => 'Fix',
                'created_at' => Carbon::now()
            ]
        ];
        DB::table('categories')->insert($categories);
    }
}
