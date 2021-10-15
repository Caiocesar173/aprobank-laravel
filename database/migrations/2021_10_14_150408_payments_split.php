<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class PaymentsSplit extends Migration
{
    /**
     * Run the migrations.
     * @return void
     * 
     * type_user = 'usuario' | 'unidade'
     * type_value = 'liquido' | 'bruto'
     * type_partition = 'valor' | 'porcentagem'
     */
    public function up()
    {
        Schema::create('payments_split', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('uuid_external');
            
            $table->uuid('bank_user_id');
            $table->foreign('bank_user_id')->references('id')->on('bank_user')->onDelete('cascade');

            $table->text('account_id');
            $table->decimal('value', 11, 2);
            $table->text('type_user');
            $table->text('type_value');
            $table->text('type_partition');

            $table->uuid('split_rules_id');
            $table->foreign('split_rules_id')->references('id')->on('split_rules')->onDelete('cascade');
            
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
        Schema::dropIfExists('payments_split');
    }
}
