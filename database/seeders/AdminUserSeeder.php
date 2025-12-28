<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (!User::where('email', 'admin@gumalandscape.com')->exists()) {
            // Buat user admin
            User::create([
                'name' => 'Administrator Guma',
                'email' => 'admin@gumalandscape.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]);
            
            $this->command->info('✅ Admin user created successfully!');
            $this->command->info('📧 Email: admin@gumalandscape.com');
            $this->command->info('🔑 Password: admin123');
        } else {
            $this->command->info('ℹ️ Admin user already exists.');
        }
        
        // Cek apakah test user sudah ada
        if (!User::where('email', 'user@example.com')->exists()) {
            // Buat test user/pelanggan
            User::create([
                'name' => 'Test User',
                'email' => 'user@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]);
            
            $this->command->info('✅ Test user created successfully!');
            $this->command->info('📧 Email: user@example.com');
            $this->command->info('🔑 Password: password123');
        } else {
            $this->command->info('ℹ️ Test user already exists.');
        }
        
        $this->command->info('🎉 Seeder completed!');
    }
}