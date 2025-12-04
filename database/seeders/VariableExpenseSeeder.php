<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\VariableExpense;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VariableExpenseSeeder extends Seeder
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

        $variableExpenses = [
            [
                'description' => 'Supermercado Extra',
                'category' => 'Alimentação',
                'amount' => 350.50,
                'expense_date' => Carbon::now()->subDays(2),
                'notes' => 'Compras do mês',
            ],
            [
                'description' => 'Restaurante Italiano',
                'category' => 'Alimentação',
                'amount' => 180.00,
                'expense_date' => Carbon::now()->subDays(5),
                'notes' => 'Jantar em família',
            ],
            [
                'description' => 'Uber',
                'category' => 'Transporte',
                'amount' => 35.50,
                'expense_date' => Carbon::now()->subDays(1),
                'notes' => null,
            ],
            [
                'description' => 'Farmácia',
                'category' => 'Saúde',
                'amount' => 87.90,
                'expense_date' => Carbon::now()->subDays(7),
                'notes' => 'Medicamentos',
            ],
            [
                'description' => 'Cinema',
                'category' => 'Lazer',
                'amount' => 90.00,
                'expense_date' => Carbon::now()->subDays(10),
                'notes' => '2 ingressos + pipoca',
            ],
            [
                'description' => 'Livro Técnico',
                'category' => 'Educação',
                'amount' => 75.00,
                'expense_date' => Carbon::now()->subDays(15),
                'notes' => 'Clean Code',
            ],
            [
                'description' => 'Combustível',
                'category' => 'Transporte',
                'amount' => 250.00,
                'expense_date' => Carbon::now()->subDays(3),
                'notes' => 'Gasolina',
            ],
            [
                'description' => 'Roupas',
                'category' => 'Vestuário',
                'amount' => 320.00,
                'expense_date' => Carbon::now()->subDays(20),
                'notes' => 'Loja ABC',
            ],
        ];

        foreach ($variableExpenses as $expense) {
            $category = $categories->firstWhere('name', $expense['category']);

            if ($category) {
                VariableExpense::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'description' => $expense['description'],
                    'amount' => $expense['amount'],
                    'expense_date' => $expense['expense_date'],
                    'notes' => $expense['notes'],
                ]);
            }
        }

        $this->command->info('Despesas variáveis criadas com sucesso!');
    }
}
