<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class FixUsers extends Command
{
    protected $signature = 'fix:users';
    protected $description = 'Fix admin users and roles';

    public function handle()
    {
        // 1. Ensure Roles Exist
        $roles = ['Super Admin', 'Admin BKD', 'Admin OPD', 'Pegawai', 'BKN'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // 2. Fix Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@verval.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $admin->password = Hash::make('password');
        $admin->save();
        $admin->assignRole('Super Admin');
        $this->info("Super Admin (admin@verval.com) password reset to 'password' and role assigned.");

        // 3. Fix Admin OPD
        $opd = User::firstOrCreate(
            ['email' => 'opd@verval.com'],
            ['name' => 'Admin OPD', 'password' => Hash::make('password')]
        );
        $opd->password = Hash::make('password');
        $opd->save();
        $opd->assignRole('Admin OPD');
        $this->info("Admin OPD (opd@verval.com) password reset to 'password' and role assigned.");

        // 4. Fix Pegawai Demo
        $pegawai = User::firstOrCreate(
            ['email' => 'budi@verval.com'],
            ['name' => 'Budi Pegawai', 'password' => Hash::make('password')]
        );
        $pegawai->password = Hash::make('password');
        $pegawai->save();
        $pegawai->assignRole('Pegawai');
        $this->info("Pegawai (budi@verval.com) password reset to 'password' and role assigned.");
    }
}
