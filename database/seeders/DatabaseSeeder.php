<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use \App\Models\Article;
use \App\Models\User;
use \App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Seed Roles
        $editor = Role::create(['name' => 'Editor', 'guard_name' => 'api']);
        $writer = Role::create(['name' => 'Writer', 'guard_name' => 'api']);

        // Seed Categories
        Category::factory(3)->create();

        // Seed Users and related Articles
        User::factory(2)->has(Article::factory()->count(1), 'articles')->create()->each(
            function ($user) {
                $user->assignRole(Role::findByName('Editor', 'api'));
            }
        );

        User::factory(2)->has(Article::factory()->count(1), 'articles')->create()->each(
            function ($user) {
                $user->assignRole(Role::findByName('Writer', 'api'));
            }
        );
    }
}
