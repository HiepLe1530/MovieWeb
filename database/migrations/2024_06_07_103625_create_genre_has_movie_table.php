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
        Schema::create('genre_has_movie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_id')->constrained('movies', 'm_id');
            $table->foreignId('g_id')->constrained('genres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_has_movie');
    }
};
