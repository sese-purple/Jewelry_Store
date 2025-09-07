<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class JewelryCategoriesSeeder extends Seeder
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
                'description' => 'Elegant rings for every occasion',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Necklaces',
                'slug' => 'necklaces',
                'description' => 'Beautiful necklaces and pendants',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Earrings',
                'slug' => 'earrings',
                'description' => 'Stunning earrings for all styles',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Bracelets',
                'slug' => 'bracelets',
                'description' => 'Charming bracelets and bangles',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Watches',
                'slug' => 'watches',
                'description' => 'Luxury watches and timepieces',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Brooches & Pins',
                'slug' => 'brooches-pins',
                'description' => 'Elegant brooches and decorative pins',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'name' => 'Gold Jewelry',
                'slug' => 'gold-jewelry',
                'description' => 'Premium gold jewelry collection',
                'sort_order' => 7,
                'is_active' => true
            ],
            [
                'name' => 'Silver Jewelry',
                'slug' => 'silver-jewelry',
                'description' => 'Beautiful silver jewelry pieces',
                'sort_order' => 8,
                'is_active' => true
            ],
            [
                'name' => 'Diamond Jewelry',
                'slug' => 'diamond-jewelry',
                'description' => 'Exquisite diamond jewelry collection',
                'sort_order' => 9,
                'is_active' => true
            ],
            [
                'name' => 'Pearl Jewelry',
                'slug' => 'pearl-jewelry',
                'description' => 'Classic pearl jewelry and accessories',
                'sort_order' => 10,
                'is_active' => true
            ],
            [
                'name' => 'Wedding Jewelry',
                'slug' => 'wedding-jewelry',
                'description' => 'Special jewelry for weddings and engagements',
                'sort_order' => 11,
                'is_active' => true
            ],
            [
                'name' => 'Men\'s Jewelry',
                'slug' => 'mens-jewelry',
                'description' => 'Sophisticated jewelry for men',
                'sort_order' => 12,
                'is_active' => true
            ],
            [
                'name' => 'Children\'s Jewelry',
                'slug' => 'childrens-jewelry',
                'description' => 'Delicate jewelry for children',
                'sort_order' => 13,
                'is_active' => true
            ],
            [
                'name' => 'Vintage & Antique',
                'slug' => 'vintage-antique',
                'description' => 'Vintage and antique jewelry pieces',
                'sort_order' => 14,
                'is_active' => true
            ],
            [
                'name' => 'Custom Jewelry',
                'slug' => 'custom-jewelry',
                'description' => 'Custom designed and personalized jewelry',
                'sort_order' => 15,
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            // Check if the category already exists
            if (!Category::where('slug', $category['slug'])->exists()) {
                Category::create($category);
            }
        }

        $this->command->info('Jewelry categories seeded successfully!');
    }
}
