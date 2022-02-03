<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Record;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id')->require();
            $table->integer('patients')->require();
            $table->string('professional')->require();
            $table->enum('type', [Record::TYPE_PEDIATRIA, Record::TYPE_URGENCIA, Record::TYPE_CGI]);
            $table->enum('state', [Record::STATE_AWAITING, Record::STATE_OCUPPED]);
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
        Schema::dropIfExists('records');
    }
}
