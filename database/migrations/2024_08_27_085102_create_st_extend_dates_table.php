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
        Schema::create('st_extend_dates', function (Blueprint $table) {
            $table->id();
            $table->string('user_email'); 
    
            // Set up the foreign key relationship to the 'email' column in the 'users' table
            $table->foreign('user_email')
                ->references('email')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('extend_date')->default(7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('st_extend_dates');
    }
};
