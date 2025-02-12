<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('boarder_id', 255);
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->string('room_name');
            $table->decimal('amount', 10, 2);
            $table->decimal('partial_amount', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->date('payment_due_date');
            $table->enum('status', ['pending', 'paid', 'partial'])->default('pending');
            $table->string('checkout_session_id')->nullable();
            $table->timestamps();

            $table->foreign('boarder_id')->references('boarder_id')->on('boarders')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
