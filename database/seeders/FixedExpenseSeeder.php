<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FixedExpense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FixedExpenseSeeder extends Seeder
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

        $categories = Category::where('user_id', $user->id)->get();

        if ($categories->isEmpty()) {
            $this->command->warn('Nenhuma categoria encontrada. Execute o CategorySeeder primeiro.');
            return;
        }

        $fixedExpenses = [
            [
                'description' => 'Aluguel',
                'category' => 'Moradia',
                'amount' => 1500.00,
                'start_date' => Carbon::now()->subMonths(6),
                'months_valid' => 12,
                'status' => true,
            ],
            [
                'description' => 'Condomínio',
                'category' => 'Moradia',
                'amount' => 350.00,
                'start_date' => Carbon::now()->subMonths(6),
                'months_valid' => 12,
                'status' => true,
            ],
            [
                'description' => 'Plano de Saúde',
                'category' => 'Saúde',
                'amount' => 450.00,
                'start_date' => Carbon::now()->subMonths(3),
                'months_valid' => 12,
                'status' => true,
            ],
            [
                'description' => 'Internet',
                'category' => 'Serviços',
                'amount' => 99.90,
                'start_date' => Carbon::now()->subMonths(12),
                'months_valid' => 12,
                'status' => true,
            ],
            [
                'description' => 'Netflix',
                'category' => 'Lazer',
                'amount' => 55.90,
                'start_date' => Carbon::now()->subMonths(8),
                'months_valid' => 6,
                'status' => true,
            ],
            [
                'description' => 'Academia',
                'category' => 'Saúde',
                'amount' => 120.00,
                'start_date' => Carbon::now()->subMonths(2),
                'months_valid' => 3,
                'status' => false,
            ],
        ];

        foreach ($fixedExpenses as $expense) {
            $category = $categories->firstWhere('name', $expense['category']);

            if ($category) {
                FixedExpense::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'description' => $expense['description'],
                    'amount' => $expense['amount'],
                    'start_date' => $expense['start_date'],
                    'months_valid' => $expense['months_valid'],
                    'status' => $expense['status'],
                ]);
            }
        }

        $this->command->info('Despesas fixas criadas com sucesso!');
    }
}
