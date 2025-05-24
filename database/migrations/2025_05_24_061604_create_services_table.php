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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('chassis_number');
            $table->string('km_run');
            $table->string('bay_number');
            $table->float('charge');
            $table->string('type');
            $table->string('img_url');
            $table->tinyInteger('status')->comment('process,complete')->default(1);
            $table->float('parts_price')->nullable();
            $table->float('total_amount')->nullable();
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->timestamp('service_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
