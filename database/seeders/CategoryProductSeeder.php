<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::all();
        $category   = Category::all();

        foreach ($product as $key => $p) {
            foreach ($category as $key => $c) {
                DB::table('category_products')->insert([
                    'product_id'  => $p->id,
                    'category_id' => $c->id,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ]);
            }
        }
    }
}
