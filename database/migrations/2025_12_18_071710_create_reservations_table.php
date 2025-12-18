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
    Schema::create('reservations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->enum('service_type', ['villa', 'wisata', 'nikah', 'mice']);
        $table->unsignedBigInteger('package_id')->nullable();
        $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
        $table->date('date');
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
        $table->text('notes')->nullable();
        $table->enum('payment_status', ['unpaid', 'paid', 'verified'])->default('unpaid');
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
        Schema::dropIfExists('reservations');
    }
};
