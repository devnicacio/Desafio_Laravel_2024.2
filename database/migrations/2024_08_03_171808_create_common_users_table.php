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
            $table->string('phoneNumber')->unique();
            $table->date('birthdate');
            $table->string('cpf')->unique();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commonUsers');
        Schema::dropIfExists('sessions');
    }
};
