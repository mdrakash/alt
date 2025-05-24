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
        Schema::create('service_parts', function (Blueprint $table) {
            $table->unsignedBigInteger('services_id');
            $table->unsignedBigInteger('parts_id');
            $table->integer('quantity');

            $table->foreign('services_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('parts_id')->references('id')->on('parts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_parts');
    }
};
