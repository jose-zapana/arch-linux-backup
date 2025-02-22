<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            [
                'name' => 'Talla',
                'type' => 1,
                'features' => [
                    [
                        'value' => 'S',
                        'description' => 'Small'

                    ],
                    [
                        'value' => 'M',
                        'description' => 'Medium'

                    ],
                    [
                        'value' => 'L',
                        'description' => 'Large'

                    ],
                    [
                        'value' => 'XL',
                        'description' => 'xLarge'

                    ],
                ]

            ],
            [
                'name' => 'Color',
                'type' => 2,
                'features' => [
                    [
                        'value' => '#000000',
                        'description' => 'Negro'
                    ],
                    [
                        'value' => '#FFFFFF',
                        'description' => 'Blanco'
                    ],
                    [
                        'value' => '#00FF00',
                        'description' => 'Verde'
                    ],
                    [
                        'value' => '#FFFF00',
                        'description' => 'Amarillo'
                    ],
                    [
                        'value' => '#0000FF',
                        'description' => 'Celeste'
                    ],
                    [
                        'value' => '#FF00FF',
                        'description' => 'Magenta'
                    ],
                ]
            ],

            [
                'name' => 'Sexo',
                'type' => 1,
                'features' => [
                    [
                        'value' => 'M',
                        'description' => 'Masculino'
                    ],
                    [
                        'value' => 'F',
                        'description' => 'Femenino'
                    ],

                ]

            ],
        ];

        foreach ($options as $option) {
            $optionModel = Option::create([
                'name' => $option['name'],
                'type' => $option['type'],
            ]);

            foreach ($option['features'] as $feature) {
                $optionModel->features()->create([
                    'value' => $feature['value'],
                    'description' => $feature['description'],
                ]);
            }
        }
    }
}
