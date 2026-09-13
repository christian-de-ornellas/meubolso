<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('income_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fixed_income_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('variable_income_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('month');
            $table->integer('year');
            $table->date('payment_date')->nullable();
            $table->boolean('received')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'month', 'year']);
            $table->index(['fixed_income_id', 'month', 'year']);
            $table->index(['variable_income_id', 'month', 'year']);

            $table->unique(['fixed_income_id', 'month', 'year'], 'unique_fixed_income_month_year');
            $table->unique(['variable_income_id', 'month', 'year'], 'unique_variable_income_month_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('income_payments');
    }
};
