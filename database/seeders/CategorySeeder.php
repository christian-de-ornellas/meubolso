<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->command->warn('Nenhum usuário encontrado. Execute o seeder de usuários primeiro.');
            return;
        }

        $categories = [
            [
                'name' => 'Moradia',
                'description' => 'Despesas relacionadas à moradia (aluguel, condomínio, IPTU)',
                'color' => '#3b82f6',
                'icon' => 'heroicon-o-home',
            ],
            [
                'name' => 'Alimentação',
                'description' => 'Compras de supermercado, restaurantes e delivery',
                'color' => '#10b981',
                'icon' => 'heroicon-o-shopping-cart',
            ],
            [
                'name' => 'Transporte',
                'description' => 'Combustível, transporte público, uber, estacionamento',
                'color' => '#f59e0b',
                'icon' => 'heroicon-o-truck',
            ],
            [
                'name' => 'Saúde',
                'description' => 'Plano de saúde, medicamentos, consultas',
                'color' => '#ef4444',
                'icon' => 'heroicon-o-heart',
            ],
            [
                'name' => 'Educação',
                'description' => 'Cursos, livros, mensalidade escolar',
                'color' => '#8b5cf6',
                'icon' => 'heroicon-o-academic-cap',
            ],
            [
                'name' => 'Lazer',
                'description' => 'Cinema, streaming, viagens, hobbies',
                'color' => '#ec4899',
                'icon' => 'heroicon-o-sparkles',
            ],
            [
                'name' => 'Vestuário',
                'description' => 'Roupas, calçados, acessórios',
                'color' => '#06b6d4',
                'icon' => 'heroicon-o-shopping-bag',
            ],
            [
                'name' => 'Serviços',
                'description' => 'Internet, telefone, TV a cabo, streaming',
                'color' => '#64748b',
                'icon' => 'heroicon-o-wifi',
            ],
            [
                'name' => 'Outros',
                'description' => 'Despesas diversas',
                'color' => '#6b7280',
                'icon' => 'heroicon-o-ellipsis-horizontal',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'user_id' => $user->id,
                'name' => $category['name'],
                'description' => $category['description'],
                'color' => $category['color'],
                'icon' => $category['icon'],
            ]);
        }

        $this->command->info('Categorias criadas com sucesso!');
    }
}
