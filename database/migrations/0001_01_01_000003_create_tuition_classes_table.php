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
        Schema::create('tuition_classes', function (Blueprint $table) {
            $table->id();
            $table->string('class_name');
            $table->string('video_link', 800);
            $table->string('tele_group', 500);
            $table->string('zoom_link', 500);
            $table->string('class_tute');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuition_classes');
    }
};
