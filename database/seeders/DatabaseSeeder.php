<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Forum;
use App\Models\Jobs;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([UserSeeder::class]);

        User::factory(15)->create();
        Forum::factory(15)->create();
        Comment::factory(15)->create();
        Company::factory(15)->create();
        Location::factory(15)->create();
        Jobs::factory(15)->create();
    }
}
