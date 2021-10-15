<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class BankSlip extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankslip', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('uuid_external');

            $table->foreignId('payer_id');
            $table->string('transactionId');
            $table->string('status')->nullable();
            $table->longText('digitableLine');
            $table->longText('url');
            $table->string('documentNumber');
            $table->decimal('value', 11, 2);
            $table->string('description');
            $table->string('instruction1');
            $table->string('instruction2');
            $table->string('instruction3');
            $table->dateTime('dueDate');
            $table->tinyInteger('penaltyType')->nullable();
            $table->decimal('penltyValue', 11, 2)->nullable();
            $table->tinyInteger('feeType')->nullable();
            $table->decimal('feeValue', 11, 2)->nullable();
            $table->tinyInteger('discountType')->nullable();
            $table->decimal('discountValue', 11, 2)->nullable();
            $table->dateTime('dueDateDiscount')->nullable();
            
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
        Schema::dropIfExists('bankslip');
    }
}
