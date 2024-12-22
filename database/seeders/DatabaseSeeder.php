<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(100)->create();

        // User::factory()->create([
        //     'name' => 'Paulo Kalleby',
        //     'email' => 'paulo.devweb@gmail.com',
        // ]);

        // Tenant::factory()->count(5)->create();

        // Tenant::query()
        //     ->inRandomOrder()
        //     ->limit(5)
        //     ->get()
        //     ->each(function (Tenant $tenant) {
        //         User::factory()->count(random_int(4, 20))->create(['tenant_id' => $tenant->id]);
        //     });

        $this->call([
            ResourcesAndPermissionsSeeder::class,
        ]);
    }
}
