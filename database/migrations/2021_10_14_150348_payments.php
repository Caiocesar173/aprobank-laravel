<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class Payments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 
     * 
     * type = 'entrada' | 'parcelado'
     * situation = 'pendente' | 'pago' | 'cancelado'
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orderId')->references('id')->on('order')->onDelete('cascade');
            $table->text('situation');
            $table->text('parcel');
            $table->text('parcel_num');
            $table->text('type');
            $table->text('value');
            $table->foreignId('reciver')->references('id')->on('user')->onDelete('cascade');
            $table->text('payement_link');
            $table->decimal('fee', 11, 2);
            $table->text('type_payment');
            $table->text('gateway');
            $table->json('extra');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
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
}
