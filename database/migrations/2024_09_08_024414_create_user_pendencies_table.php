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
        Schema::create('user_pendencies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('senderAccount', 7)->nullable();
            $table->string('recipientAccount', 7)->nullable();
            $table->double('value');
            $table->date('date');
            $table->foreignId('manager')->constrained('managers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_pendencies');
    }
};
