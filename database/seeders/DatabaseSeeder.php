<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Opd;
use App\Models\Dokumen;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Ensure roles exist (needs Spatie migration run first)
        // We will wrap in try-catch in case migration wasn't run, but standard flow assumes migration first.

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = ['Super Admin', 'Admin BKD', 'Admin OPD', 'Pegawai', 'BKN'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // OPD
        Opd::firstOrCreate(['kode' => '123'], ['nama' => 'Dinas Kominfo']);

        // Users
        $admin = User::firstOrCreate(['email' => 'admin@verval.com'], [
            'name' => 'Super Admin',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Super Admin');

        $adminOpd = User::firstOrCreate(['email' => 'opd@verval.com'], [
            'name' => 'Admin OPD',
            'password' => bcrypt('password'),
        ]);
        $adminOpd->assignRole('Admin OPD');

        $pegawai = User::firstOrCreate(['email' => 'budi@verval.com'], [
            'name' => 'Budi Pegawai',
            'password' => bcrypt('password'),
        ]);
        $pegawai->assignRole('Pegawai');

        // Documents
        $docs = ['SK CPNS', 'SK PNS', 'Ijazah Terakhir', 'Kartu Pegawai', 'SK Jabatan'];
        foreach ($docs as $doc) {
            Dokumen::firstOrCreate(['nama' => $doc], ['is_required' => true]);
        }
    }
}
