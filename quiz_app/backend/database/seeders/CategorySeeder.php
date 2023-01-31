<?php

namespace Database\Seeders;

use App\Models\Models\Category;
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
        $categories = [
            [
                'name' => 'Điện thoại',
                'children' => [
                    [
                        'name' => 'Iphone',
                        'children' => [
                            ['name' => 'Iphone 11'],
                            ['name' => 'Iphone 12'],
                            ['name' => 'Iphone 13'],
                        ],
                    ],
                    [
                        'name' => 'Sam Sung',
                    ],
                    [
                        'name' => 'Xiaomi',
                    ],
                ],
                'user_id' => 1
            ],
            [
                'name' => 'Phụ kiện',
                'children' => [
                    [
                        'name' => 'Tai nghe',
                        'name' => 'Pin dự phònd',
                        'name' => 'Củ sạc iphone, ipad',
                    ],
                ],
                'user_id' => 1
            ],

            [
                'name' => 'Linh kiện',
                'children' => [
                    [
                        'name' => 'Pin Pisen',
                        'name' => 'Pin EU',
                        'name' => 'Màn hình',
                    ],
                ],
                'user_id' => 1
            ]

        ];
        foreach($categories as $category)
        {
            Category::create($category);
        }
    }
}
