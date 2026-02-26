<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Seeder;

class SitesTableSeeder extends Seeder
{
    public function run()
    {
        $sites = [
            [
                'name'    => 'Downtown Branch',
                'address' => '123 Main Street, Downtown',
            ],
            [
                'name'    => 'Mid-town Office',
                'address' => '456 Oak Avenue, Mid-town',
            ],
            [
                'name'    => 'Uptown Facility',
                'address' => '789 Elm Road, Uptown',
            ],
        ];

        foreach ($sites as $site) {
            Site::updateOrCreate(['name' => $site['name']], $site);
        }
    }
}
