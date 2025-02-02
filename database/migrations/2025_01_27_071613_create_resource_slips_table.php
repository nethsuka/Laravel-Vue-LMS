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
        Schema::create('resource_slips', function (Blueprint $table) {
            $table->id();
            $table->string('st_name');
            $table->string('st_email');
            $table->string('resource_names', 1000);
            $table->string('slip_url');
            $table->string('note')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource_slips');
    }
};
