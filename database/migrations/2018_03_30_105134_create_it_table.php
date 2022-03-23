<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itjob', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('slug');
            $table->integer('id_unit')->unsigned();
            $table->string("nama_user_request")->nullable();
            $table->text('problem')->nullable();
            $table->string("it_solved_by")->nullable();
            $table->date('tgl_kejadian')->nullabel();
            $table->time('waktu_kejadian')->nullable();
            $table->text("solusi")->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            $table->foreign('id_unit')->references('id')->on('unit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('it');
    }
}
