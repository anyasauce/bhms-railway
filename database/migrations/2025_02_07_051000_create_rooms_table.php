<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_name');
            $table->integer('slots')->default(0);
            $table->decimal('price', 8, 2)->default(0.00);
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->string('room_image')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('rooms');
    }
};
