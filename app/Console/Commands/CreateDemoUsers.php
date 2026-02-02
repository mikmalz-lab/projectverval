<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateDemoUsers extends Command
{
    protected $signature = 'demo:create';
    protected $description = 'Create 4 demo users for each role';

    public function handle()
    {
        $users = [
            // 1. Super Admin
            [
                'name' => 'Super Admin',
                'email' => 'admin@verval.com',
                'role' => 'Super Admin'
            ],
            // 2. Admin OPD
            [
                'name' => 'Admin Kominfo',
                'email' => 'opd@verval.com',
                'role' => 'Admin OPD'
            ],
            // 3. Admin BKD (Validator)
            [
                'name' => 'Admin BKD',
                'email' => 'bkd@verval.com',
                'role' => 'Admin BKD'
            ],
            // 4. Pegawai
            [
                'name' => 'Budi Pegawai',
                'email' => 'budi@verval.com',
                'role' => 'Pegawai'
            ],
            // Bonus: BKN Viewer
            [
                'name' => 'Pengawas BKN',
                'email' => 'bkn@verval.com',
                'role' => 'BKN'
            ]
        ];

        foreach ($users as $u) {
            $user = User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('password')
                ]
            );

            // Force sync roles
            $user->syncRoles([$u['role']]);

            // Special setup for Pegawai demo data
            if ($u['role'] == 'Pegawai') {
                \App\Models\Pegawai::firstOrCreate(
                    ['user_id' => $user->id],
                    ['nama_lengkap' => $u['name'], 'nip' => '199001012022011001']
                );
            }

            $this->info("User {$u['role']} ready: {$u['email']}");
        }
    }
}
