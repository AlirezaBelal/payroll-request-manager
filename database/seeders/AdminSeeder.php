<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'مدیر سیستم',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123456'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'کارشناس منابع انسانی',
            'email' => 'hr@example.com',
            'password' => Hash::make('hr123456'),
            'role' => 'hr',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'کارشناس مالی',
            'email' => 'finance@example.com',
            'password' => Hash::make('finance123456'),
            'role' => 'finance',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'کارمند نمونه',
            'email' => 'employee@example.com',
            'password' => Hash::make('employee123456'),
            'role' => 'employee',
            'email_verified_at' => now(),
        ]);
    }
}
