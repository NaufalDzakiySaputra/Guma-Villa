<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('nama');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);

            // Batas maksimal jumlah orang untuk paket
            $table->unsignedInteger('max_people')->default(1);

            $table->enum('service_type', ['villa', 'wisata', 'nikah', 'mice']);
            $table->string('image_path')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('packages');
    }
};