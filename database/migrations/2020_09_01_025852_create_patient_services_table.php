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
            $table->string('type');
            $table->integer('patientid')->nullable();
            $table->string('name')->nullable();
            $table->string('organization')->nullable();
            $table->date('docdate');
            $table->string('bloodpressure')->nullable();
            $table->decimal('temperature', 8, 1)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('or_number')->nullable();
            $table->string('note')->nullable();
            $table->decimal('grand_total', 8, 2);
            $table->string('status');
            $table->string('cancelled');
            $table->date('canceldate')->nullable();
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
