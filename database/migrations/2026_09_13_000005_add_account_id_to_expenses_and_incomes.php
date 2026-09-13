<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fixed_expenses', function (Blueprint $table) {
            $table->foreignId('account_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
        });

        Schema::table('variable_expenses', function (Blueprint $table) {
            $table->foreignId('account_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
        });

        Schema::table('fixed_incomes', function (Blueprint $table) {
            $table->foreignId('account_id')->nullable()->after('income_category_id')->constrained()->nullOnDelete();
        });

        Schema::table('variable_incomes', function (Blueprint $table) {
            $table->foreignId('account_id')->nullable()->after('income_category_id')->constrained()->nullOnDelete();
        });

        Schema::table('expense_payments', function (Blueprint $table) {
            $table->foreignId('account_id')->nullable()->after('variable_expense_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('fixed_expenses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('account_id');
        });

        Schema::table('variable_expenses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('account_id');
        });

        Schema::table('fixed_incomes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('account_id');
        });

        Schema::table('variable_incomes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('account_id');
        });

        Schema::table('expense_payments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('account_id');
        });
    }
};
