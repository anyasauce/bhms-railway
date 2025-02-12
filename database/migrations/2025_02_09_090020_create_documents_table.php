<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('boarder_id', 255);
            $table->string('email');
            $table->string('psa_birth_cert');
            $table->string('boarder_valid_id');
            $table->string('boarder_selfie');
            $table->string('guardian_valid_id');
            $table->string('guardian_selfie');
            $table->timestamps();

            $table->foreign('boarder_id')->references('boarder_id')->on('boarders')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
