<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('variable_expenses', function (Blueprint $table) {
            $table->foreignId('credit_card_id')->nullable()->after('account_id')->constrained()->nullOnDelete();
        });

        Schema::table('fixed_expenses', function (Blueprint $table) {
            $table->foreignId('credit_card_id')->nullable()->after('account_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('variable_expenses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('credit_card_id');
        });

        Schema::table('fixed_expenses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('credit_card_id');
        });
    }
};
