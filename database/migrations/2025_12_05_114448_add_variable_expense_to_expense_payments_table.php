<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('expense_payments', function (Blueprint $table) {
            // Remover o unique constraint antigo
            $table->dropUnique('unique_expense_month_year');

            // Tornar fixed_expense_id nullable
            $table->foreignId('fixed_expense_id')->nullable()->change();

            // Adicionar variable_expense_id
            $table->foreignId('variable_expense_id')->nullable()->after('fixed_expense_id')->constrained()->cascadeOnDelete();

            // Adicionar índice para variable_expense_id
            $table->index(['variable_expense_id', 'month', 'year']);

            // Adicionar novos unique constraints
            // Para despesas fixas: não pode duplicar fixed_expense + mês/ano
            $table->unique(['fixed_expense_id', 'month', 'year'], 'unique_fixed_expense_month_year');

            // Para despesas variáveis: não pode duplicar variable_expense + mês/ano
            $table->unique(['variable_expense_id', 'month', 'year'], 'unique_variable_expense_month_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_payments', function (Blueprint $table) {
            // Remover unique constraints novos
            $table->dropUnique('unique_fixed_expense_month_year');
            $table->dropUnique('unique_variable_expense_month_year');

            // Remover índice e coluna variable_expense_id
            $table->dropIndex(['variable_expense_id', 'month', 'year']);
            $table->dropForeign(['variable_expense_id']);
            $table->dropColumn('variable_expense_id');

            // Restaurar fixed_expense_id como not null
            $table->foreignId('fixed_expense_id')->nullable(false)->change();

            // Restaurar unique constraint antigo
            $table->unique(['fixed_expense_id', 'month', 'year'], 'unique_expense_month_year');
        });
    }
};
