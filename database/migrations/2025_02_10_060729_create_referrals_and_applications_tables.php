<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('referral_code')->nullable();
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->timestamps();
        });

        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->string('referrer_id');
            $table->unsignedBigInteger('referred_application_id');
            $table->integer('points')->default(0);
            $table->timestamps();

            $table->foreign('referrer_id')->references('boarder_id')->on('boarders')->onDelete('cascade');
            $table->foreign('referred_application_id')->references('id')->on('applications')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('applications');
    }
};
