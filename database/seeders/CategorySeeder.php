<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Category::create([
            'name' => 'Electronics',
            'description' => 'Latest electronic gadgets and devices.',
            'image' => 'https://via.placeholder.com/150'
        ]);

        Category::create([
            'name' => 'Fashion',
            'description' => 'Trendy clothing and accessories.',
            'image' => 'https://via.placeholder.com/150'
        ]);

        Category::create([
            'name' => 'Home & Garden',
            'description' => 'Furniture, decor, and gardening tools.',
            'image' => 'https://via.placeholder.com/150'
        ]);

        Category::create([
            'name' => 'Sports',
            'description' => 'Equipment and gear for various sports.',
            'image' => 'https://via.placeholder.com/150'
        ]);
    }
}
