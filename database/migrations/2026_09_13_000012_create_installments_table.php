<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('installment_expense_id')->constrained()->cascadeOnDelete();
            $table->integer('installment_number');
            $table->decimal('amount', 10, 2);
            $table->date('due_date');
            $table->boolean('paid')->default(false);
            $table->date('payment_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['installment_expense_id', 'installment_number']);
            $table->index(['user_id', 'due_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
