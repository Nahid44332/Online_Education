<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'image' => 'banner1.jpg'
            ],

            [
                'image' => 'banner2.jpg'
            ],

            [
                'image' => 'banner3.jpg'
            ]
        ];

        Banner::insert($banners);
    }
}
