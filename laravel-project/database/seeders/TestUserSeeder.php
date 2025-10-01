<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminUser;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criar um usuário gestor regular (sem acesso ao gerenciamento de usuários)
        AdminUser::create([
            'name' => 'João Silva',
            'username' => 'joao',
            'password' => '123456',
            'area' => 'Vendas',
            'role' => 'gestor',
            'active' => true,
        ]);

        echo "Usuário de teste criado!\n";
        echo "Usuário: joao\n";
        echo "Senha: 123456\n";
        echo "Tipo: Gestor (sem acesso ao gerenciamento de usuários)\n";
    }
}
