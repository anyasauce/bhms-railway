<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration {
    public function up()
    {
        Schema::create('boarders', function (Blueprint $table) {
            $table->id();
            $table->string('boarder_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->string('guardian_name');
            $table->string('guardian_phone_number');
            $table->text('address');
            $table->decimal('balance', 8, 2)->default(0.00);
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->string('reset_token')->nullable();
            $table->string('referral_code')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('boarders');
    }
};
