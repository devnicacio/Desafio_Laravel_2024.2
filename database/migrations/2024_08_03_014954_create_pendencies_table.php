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
        Schema::create('pendencies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreign('senderAccount')->references('id')->on('accounts');
            $table->string('recipientAccount')->nullable();
            $table->string('recipientAgency')->nullable();
            $table->double('value');
            $table->date('date');
            $table->boolean('status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendencies');
    }
};
