<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Seed the articles available for a pickup.
     */
    public function run(): void
    {
        $articles = [
            [
                'name' => 'Chemise',
                'image_url' => '/images/articles/chemise.jpg',
                'type' => 'Vêtements',
                'usage' => ['Lavage', 'Repassage'],
                'unit_price' => 4.50,
                'weight_ranges' => ['léger' => [0.15, 0.25], 'standard' => [0.25, 0.35], 'épais' => [0.35, 0.5]],
            ],
            [
                'name' => 'Pantalon',
                'image_url' => '/images/articles/pantalon.jpg',
                'type' => 'Vêtements',
                'usage' => ['Lavage', 'Repassage'],
                'unit_price' => 5.00,
                'weight_ranges' => ['léger' => [0.3, 0.4], 'standard' => [0.4, 0.6], 'épais' => [0.6, 0.8]],
            ],
            [
                'name' => 'Pull',
                'image_url' => '/images/articles/pull.jpg',
                'type' => 'Vêtements',
                'usage' => ['Lavage'],
                'unit_price' => 6.00,
                'weight_ranges' => ['léger' => [0.3, 0.45], 'standard' => [0.45, 0.6], 'épais' => [0.6, 0.9]],
            ],
            [
                'name' => 'Drap',
                'image_url' => '/images/articles/drap.jpg',
                'type' => 'Linge de maison',
                'usage' => ['Lavage', 'Repassage'],
                'unit_price' => 7.50,
                'weight_ranges' => ['léger' => [0.5, 0.8], 'standard' => [0.8, 1.2], 'épais' => [1.2, 1.8]],
            ],
            [
                'name' => 'Housse de couette',
                'image_url' => '/images/articles/housse.jpg',
                'type' => 'Linge de maison',
                'usage' => ['Lavage', 'Repassage'],
                'unit_price' => 9.00,
                'weight_ranges' => ['léger' => [0.8, 1.2], 'standard' => [1.2, 1.8], 'épais' => [1.8, 2.5]],
            ],
            [
                'name' => 'Robe en soie',
                'image_url' => '/images/articles/robe.jpg',
                'type' => 'Délicat',
                'usage' => ['Nettoyage à sec'],
                'unit_price' => 12.00,
                'weight_ranges' => ['léger' => [0.1, 0.2], 'standard' => [0.2, 0.3], 'épais' => [0.3, 0.45]],
            ],
            [
                'name' => 'Costume',
                'image_url' => '/images/articles/costume.jpg',
                'type' => 'Délicat',
                'usage' => ['Nettoyage à sec', 'Repassage'],
                'unit_price' => 15.00,
                'weight_ranges' => ['léger' => [0.6, 0.9], 'standard' => [0.9, 1.3], 'épais' => [1.3, 1.8]],
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(['name' => $article['name']], $article);
        }
    }
}
