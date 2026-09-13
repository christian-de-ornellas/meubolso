<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remover registros soft-deleted permanentemente antes de remover a coluna
        DB::table('expense_payments')->whereNotNull('deleted_at')->delete();

        Schema::table('expense_payments', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_payments', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
};
