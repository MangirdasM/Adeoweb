<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $materials = ['Leather', 'Wooden', 'Plastic', 'Cloth', 'Steel'];
        $products = ['Hat', 'Sweater', 'Coat', 'Umbrella', 'Shorts', 'Pants'];
        $faker = fake();
        $product_name = $faker->randomElement($products);
        $material_name = $faker->randomElement($materials);
        
        return [
            'name' => $material_name .' '. $product_name,
            'sku' => $faker->numerify($material_name[0].$product_name[0].'-##'),
            'price' => $faker->randomFloat(2,1,50)
        ];
    }
}
