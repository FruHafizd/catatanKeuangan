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
        Schema::create('debt_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('debt_name');
            $table->unsignedBigInteger('total_loan');
            $table->enum('tenor_unit',['year','month'])->default('month');
            $table->integer('tenor_value');
            $table->enum('income_type',['daily','weekly','yearly']);
            $table->unsignedBigInteger('income_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt_plans');
    }
};
