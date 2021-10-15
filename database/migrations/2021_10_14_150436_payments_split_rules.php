<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class PaymentsSplitRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_split_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('uuid_external');
            
            $table->text('name');
            $table->text('type_user');
            $table->text('type_value');
            $table->decimal('value', 11, 2);

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
        Schema::dropIfExists('payments_split_rules');
    }
}
