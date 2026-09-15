<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('income_payments', function (Blueprint $table) {
            $table->boolean('dismissed')->default(false)->after('received');
        });
    }

    public function down(): void
    {
        Schema::table('income_payments', function (Blueprint $table) {
            $table->dropColumn('dismissed');
        });
    }
};
