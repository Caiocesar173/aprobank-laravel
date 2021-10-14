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
            $table->id();
            $table->foreignId('userId')->references('id')->on('user')->onDelete('cascade');
            $table->foreignId('accountId')->references('id')->on('accounts')->onDelete('cascade');
            $table->text('value');
            $table->text('type_user');
            $table->text('type_value');
            $table->text('type_partition');
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
        Schema::dropIfExists('payments_split');
    }
}
