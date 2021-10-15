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
            $table->uuid('id')->primary();
            $table->uuid('uuid_external');
            
            $table->text('order_id');
            $table->text('situation');
            $table->integer('parcel');
            $table->text('parcel_num');
            $table->text('type');
            $table->decimal('value', 11, 2);
            
            $table->uuid('reciver_id');
            $table->foreign('reciver_id')->references('id')->on('bank_user')->onDelete('cascade');

            $table->text('payement_link');
            $table->decimal('fee', 11, 2);
            $table->text('type_payment');
            $table->text('gateway');
            $table->json('extra');
            
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
}
