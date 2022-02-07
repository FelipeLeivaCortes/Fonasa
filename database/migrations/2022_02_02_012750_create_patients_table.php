<?php

use App\Models\Patient;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id')->require();
            $table->string('name')->require();
            $table->integer('age')->require();
            $table->integer('noHistoriaClinica')->default(0);
            $table->enum('category', [Patient::CHILD, Patient::ADULT, Patient::OLDMAN]);
            $table->enum('state', [Patient::IN_LOBBY, Patient::AWAITING, Patient::ATTENDED])->default(Patient::IN_LOBBY);
            $table->timestamps();

            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
