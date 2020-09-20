<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_services', function (Blueprint $table) {
            $table->id();
            $table->integer('patientid');
            $table->string('patientname');
            $table->date('docdate');
            $table->string('bloodpressure')->nullable();
            $table->string('or_number')->nullable();
            $table->string('note')->nullable();
            $table->decimal('grand_total', 8, 2);
            $table->string('cancelled');
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
        Schema::dropIfExists('patient_services');
    }
}
