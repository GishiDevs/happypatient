<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_procedures', function (Blueprint $table) {
            $table->id();
            $table->integer('serviceid');
            $table->string('code');
            $table->string('procedure');
            $table->decimal('price', 8, 2);
            $table->string('to_diagnose');
            $table->string('is_multiple')->nullable();
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
        Schema::dropIfExists('service_procedures');
    }
}
