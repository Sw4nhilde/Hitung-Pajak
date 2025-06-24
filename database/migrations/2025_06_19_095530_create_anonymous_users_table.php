<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('anonymous_users', function (Blueprint $table) {
            $table->id();
            $table->uuid('anon_id')->unique(); // Unique anonymous ID
            $table->timestamps();              // For tracking first/last visit
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anonymous_users');
    }
};
