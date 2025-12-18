<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('reservation_id');
        $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
        $table->decimal('amount', 12, 2);
        $table->string('method');
        $table->string('transaction_code')->unique();
        $table->enum('status', ['pending', 'success', 'failed', 'verified'])->default('pending');
        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
