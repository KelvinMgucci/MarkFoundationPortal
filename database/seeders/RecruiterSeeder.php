<?php

namespace Database\Seeders;

use App\Models\Recruiter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RecruiterSeeder extends Seeder
{
    /**
     * Run with: php artisan db:seed --class=RecruiterSeeder
     *
     * Then log in at /admin/login with:
     *   Email:    admin@company.com
     *   Password: changeme123
     *
     * ⚠ CHANGE THE PASSWORD before going to production.
     */
    public function run(): void
    {
        Recruiter::updateOrCreate(
            ['email' => 'admin@company.com'],
            [
                'name'     => 'Admin Recruiter',
                'password' => Hash::make('changeme123'),
            ]
        );

        $this->command->info('Recruiter seeded:  admin@company.com  /  changeme123');
        $this->command->warn('Remember to change this password before going live!');
    }
}
