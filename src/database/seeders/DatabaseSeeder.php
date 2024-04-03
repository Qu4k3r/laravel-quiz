<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (App::environment(['production', 'prod', 'staging', 'homologation', 'homol'])) {
            return;
        }
//        User::factory(3)->create();
//        Theme::factory()->create();
    }
}
