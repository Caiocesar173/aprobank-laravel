<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaymentAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_account', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('uuid_external');

            $table->text('name');
            $table->text('status');
            $table->text('type_user');
            /*
             * Crira o campo responsavel (Morph) -> salvando a classe do pagamento
             */
            $table->uuid('bank_user_id');
            $table->foreign('bank_user_id')->references('id')->on('bank_user')->onDelete('cascade');
            
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
        Schema::dropIfExists('payment_account');
    }
}
