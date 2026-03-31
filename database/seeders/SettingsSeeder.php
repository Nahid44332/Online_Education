<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seetings = [
            [
                'sitename' => 'Nahid Computer Training Center',
                'site_description' => 'Donec vitae sapien ut libearo venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt  Sed fringilla mauri amet nibh.',
                'address' => 'Gazipur Sadar, Gazipur',
                'phone' => '+8801968400331',
                'email' => 'nahid@gmail.com',
                'opening' => '8 AM To 10 PM',
                'helpline' => '+8801822900461',
                'facebook' => 'https://www.facebook.com/',
                'twitter' => 'https://x.com/',
                'google' => 'http://google.com/',
                'instagram' => 'instagram.com',
                'logo' => 'logo.png'
            ]
        ];

        Settings::insert($seetings);
    }
}
