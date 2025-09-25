<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criar o usuário super administrador
        AdminUser::create([
            'name' => 'Super Administrador',
            'username' => 'admin',
            'password' => '123456',
            'area' => 'Administração',
            'role' => 'super_admin',
            'active' => true,
        ]);

        echo "Super administrador criado!\n";
        echo "Usuário: admin\n";
        echo "Senha: 123456\n";
    }
}
