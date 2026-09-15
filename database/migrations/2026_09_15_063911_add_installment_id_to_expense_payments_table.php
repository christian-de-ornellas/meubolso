<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expense_payments', function (Blueprint $table) {
            $table->foreignId('installment_id')
                ->nullable()
                ->after('variable_expense_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->index(['installment_id', 'month', 'year']);
            $table->unique(['installment_id', 'month', 'year'], 'unique_installment_month_year');
        });
    }

    public function down(): void
    {
        Schema::table('expense_payments', function (Blueprint $table) {
            $table->dropUnique('unique_installment_month_year');
            $table->dropIndex(['installment_id', 'month', 'year']);
            $table->dropForeign(['installment_id']);
            $table->dropColumn('installment_id');
        });
    }
};
