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
        Schema::create('class_tutes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tuition_class_id') // This creates the 'user_id' column
                  ->constrained('tuition_classes') // This references the 'id' column on the 'users' table
                  ->onDelete('cascade');
            $table->string('tute_path');
            $table->string('tute_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_tutes');
    }
};
