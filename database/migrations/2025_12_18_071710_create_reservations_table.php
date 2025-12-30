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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // DATA PELANGGAN (BARU)
            $table->string('nama_lengkap');
            $table->string('nik', 16);
            $table->string('no_telepon', 15);
            
            $table->enum('service_type', ['villa', 'wisata', 'nikah', 'mice']);
            $table->unsignedBigInteger('package_id')->nullable();
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
            
            // TANGGAL (DIPERBAIKI)
            $table->date('date'); // tanggal reservasi dibuat
            $table->date('checkin_date');  // BARU: checkin
            $table->date('checkout_date'); // BARU: checkout
            
            // JUMLAH & HARGA (BARU)
            $table->integer('jumlah_orang')->default(1);
            $table->decimal('total_amount', 15, 2)->nullable();
            
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            
            // PEMBAYARAN (DIPERBAIKI)
            $table->enum('payment_status', ['pending', 'paid', 'verified', 'expired', 'failed'])->default('pending');
            $table->enum('payment_method', ['transfer', 'bank', 'credit_card', 'cash', 'qris'])->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};