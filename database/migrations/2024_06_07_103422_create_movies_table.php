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
        Schema::create('movies', function (Blueprint $table) {
            $table->id('m_id');
            $table->string('m_Image', 255);
            $table->string('m_Title', 255);
            $table->string('m_Director', 255);
            $table->string('m_ReleaseYear', 10);
            $table->text('m_Description');
            $table->string('m_Poster', 255);
            $table->string('m_Slug', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
