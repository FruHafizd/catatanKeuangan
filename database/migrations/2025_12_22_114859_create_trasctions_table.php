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
        Schema::create('trasctions', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->bigInteger("amount_money");
            $table->enum("type_transaction",["Income","Expenditure"])->default("Expenditure");
            $table->enum("payment_method",["Cash","Debit","E-wallet"])->default("Cash");
            $table->text("information");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trasctions');
    }
};
