<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fixed_expense_id')->constrained()->cascadeOnDelete();
            $table->integer('month'); // 1-12
            $table->integer('year'); // 2025, 2026, etc
            $table->date('payment_date')->nullable();
            $table->boolean('paid')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Índices para performance
            $table->index(['user_id', 'month', 'year']);
            $table->index(['fixed_expense_id', 'month', 'year']);

            // Garantir que não haja duplicação de pagamento para mesma despesa no mesmo mês
            $table->unique(['fixed_expense_id', 'month', 'year'], 'unique_expense_month_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense_payments');
    }
};
