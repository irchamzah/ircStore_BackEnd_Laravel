<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryIds = Category::pluck('id')->toArray();

        Product::create([
            'category_id' => $categoryIds[array_rand($categoryIds)],
            'name' => 'Smartphone',
            'description' => 'Latest model with high-end features.',
            'price' => 499.99,
            'stock' => 25,
            'image' => 'https://via.placeholder.com/200',
            'is_featured' => true
        ]);

        Product::create([
            'category_id' => $categoryIds[array_rand($categoryIds)],
            'name' => 'Stylish Watch',
            'description' => 'Elegant watch with a modern design.',
            'price' => 149.99,
            'stock' => 50,
            'image' => 'https://via.placeholder.com/200',
            'is_featured' => false
        ]);

        Product::create([
            'category_id' => $categoryIds[array_rand($categoryIds)],
            'name' => 'Garden Tools Set',
            'description' => 'Complete set of gardening tools.',
            'price' => 79.99,
            'stock' => 15,
            'image' => 'https://via.placeholder.com/200',
            'is_featured' => false
        ]);

        Product::create([
            'category_id' => $categoryIds[array_rand($categoryIds)],
            'name' => 'Fitness Tracker',
            'description' => 'Track your fitness and health metrics.',
            'price' => 199.99,
            'stock' => 30,
            'image' => 'https://via.placeholder.com/200',
            'is_featured' => true
        ]);
    }
}
