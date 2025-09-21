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
        Schema::create('prizes', function (Blueprint $table) {
            $table->id();
            $table->string('mvp')->nullable();
            $table->string('second_winner')->nullable();
            $table->string('third_winner')->nullable();
            $table->string('fourth_winner')->nullable();
            $table->string('fifth_winner')->nullable();
            $table->decimal('total_grand_prize', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prizes');
    }
};
