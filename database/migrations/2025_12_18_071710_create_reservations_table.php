<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('nama_lengkap');
            $table->string('nik', 16);
            $table->string('no_telepon', 20);

            $table->enum('service_type', ['villa', 'wisata', 'nikah', 'mice']);

            $table->foreignId('package_id')
                  ->nullable()
                  ->constrained('packages')
                  ->nullOnDelete();

            $table->date('date');
            $table->date('checkin_date');
            $table->date('checkout_date');

            $table->unsignedInteger('jumlah_orang')->default(1);
            $table->decimal('total_amount', 15, 2)->default(0);

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();

            $table->enum('payment_status', ['pending', 'paid', 'verified', 'expired', 'failed'])->default('pending');
            $table->enum('payment_method', ['transfer', 'bank', 'credit_card', 'cash', 'qris'])->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('payment_status');
            $table->index('checkin_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};