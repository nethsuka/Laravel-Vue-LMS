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
        Schema::create('extra_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('st_id') // This creates the 'user_id' column
                  ->constrained('users') // This references the 'id' column on the 'users' table
                  ->onDelete('cascade'); // If a user is deleted, their posts are deleted as well
            $table->string('st_name');
            $table->string('st_email');
            $table->string('name')->nullable();
            $table->string('video_link', 800);
            $table->date('expiry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_videos');
    }
};
