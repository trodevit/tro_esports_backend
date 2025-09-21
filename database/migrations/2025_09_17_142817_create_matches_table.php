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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('match_name');
            $table->string('category');
            $table->decimal('entry_fee', 10, 2)->default(0);
            $table->integer('player_limit')->default(1);
            $table->date('match_date');
            $table->time('match_time');
            $table->longText('instructions')->nullable();
            $table->decimal('grand_prize', 10, 2)->default(0);
            $table->decimal('per_kill_price', 10, 2)->default(0);
            $table->string('match_type');
            $table->string('map_type');
            $table->string('version');
            $table->text('room_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
