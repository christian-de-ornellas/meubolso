<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('last_four_digits', 4)->nullable();
            $table->string('brand')->nullable();
            $table->decimal('credit_limit', 10, 2)->default(0);
            $table->integer('closing_day');
            $table->integer('due_day');
            $table->string('color')->default('#3b82f6');
            $table->string('icon')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('credit_cards');
    }
};
