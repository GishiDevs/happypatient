<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientServiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_service_items', function (Blueprint $table) {
            $table->id();
            $table->integer('psid');
            $table->integer('serviceid');
            $table->integer('procedureid');
            $table->decimal('price', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('discount_amt', 8, 2);
            $table->decimal('total_amount', 8, 2);
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_service_items');
    }
}
