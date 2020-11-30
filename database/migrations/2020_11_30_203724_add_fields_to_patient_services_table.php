<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPatientServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_services', function (Blueprint $table) {
            $table->string('physician')->nullable();
            $table->decimal('o2_sat', 8, 2)->nullable();
            $table->integer('pulserate')->nullable();
            $table->date('lmp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_services', function (Blueprint $table) {
            $table->dropColumn('physician');
            $table->dropColumn('o2_sat');
            $table->dropColumn('pulserate');
            $table->dropColumn('lmp');
        });
    }
}
