<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reservation_id');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('method');
            $table->string('transaction_code')->unique();
            $table->enum('status', ['pending', 'paid', 'failed', 'verified', 'expired'])->default('pending');
            
            // BUKTI PEMBAYARAN (BARU)
            $table->string('proof_image')->nullable();
            $table->text('payment_notes')->nullable();
            
            $table->timestamp('paid_at')->nullable();
            
            // VERIFIKASI (BARU)
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};