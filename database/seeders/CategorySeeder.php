<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Rings',
                'slug' => 'rings',
                'description' => 'Beautiful rings for all occasions - engagement, wedding, fashion rings',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Necklaces',
                'slug' => 'necklaces',
                'description' => 'Elegant necklaces and pendants in various styles and materials',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Earrings',
                'slug' => 'earrings',
                'description' => 'Stunning earrings - studs, hoops, drops, and chandelier styles',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Bracelets',
                'slug' => 'bracelets',
                'description' => 'Stylish bracelets and bangles for every wrist',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Watches',
                'slug' => 'watches',
                'description' => 'Premium watches for men and women - luxury and fashion timepieces',
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'name' => 'Chains',
                'slug' => 'chains',
                'description' => 'Gold, silver, and platinum chains in various lengths and styles',
                'is_active' => true,
                'sort_order' => 6
            ],
            [
                'name' => 'Anklets',
                'slug' => 'anklets',
                'description' => 'Delicate anklets and ankle bracelets',
                'is_active' => true,
                'sort_order' => 7
            ],
            [
                'name' => 'Brooches & Pins',
                'slug' => 'brooches-pins',
                'description' => 'Decorative brooches and pins for special occasions',
                'is_active' => true,
                'sort_order' => 8
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
