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
            $table->foreignId('senderAccount')->constrained('accounts');
            $table->foreignId('recipientAccount')->constrained('accounts')->nullable();
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
