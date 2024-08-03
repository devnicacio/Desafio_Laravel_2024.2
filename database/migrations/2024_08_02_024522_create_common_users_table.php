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
        Schema::create('commonUsers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('account');
            $table->foreign('account')->references('id')->on('accounts');
            $table->unsignedBigInteger('manager');
            $table->foreign('manager')->references('id')->on('managers');
            $table->string('address');
            $table->string('photo');
            $table->string('phoneNumber');
            $table->date('birthdate');
            $table->string('cpf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commonUsers');
    }
};
