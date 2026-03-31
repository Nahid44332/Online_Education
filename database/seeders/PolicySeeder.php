<?php

namespace Database\Seeders;

use App\Models\Policy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $policies = [
            [
                'privacy_policy' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Id suscipit beatae, tenetur, omnis non accusantium ex maiores repellendus mollitia, harum quas? Aliquam facilis iusto voluptates placeat ab repudiandae reiciendis vel.',
                'trams_condition' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Id suscipit beatae, tenetur, omnis non accusantium ex maiores repellendus mollitia, harum quas? Aliquam facilis iusto voluptates placeat ab repudiandae reiciendis vel.',
                'admission_policy' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Id suscipit beatae, tenetur, omnis non accusantium ex maiores repellendus mollitia, harum quas? Aliquam facilis iusto voluptates placeat ab repudiandae reiciendis vel.',
                'payment_policy' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Id suscipit beatae, tenetur, omnis non accusantium ex maiores repellendus mollitia, harum quas? Aliquam facilis iusto voluptates placeat ab repudiandae reiciendis vel.'
            ]
        ];

        Policy::insert($policies);
    }
}
