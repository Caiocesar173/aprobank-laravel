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
            $table->id();

            $table->text('name');
            $table->text('type_user')->useCurrent();;
            $table->text('type_value')->useCurrent();;
            $table->text('value')->useCurrent();;
            $table->foreignId('userId')->references('id')->on('user')->onDelete('cascade');

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
        Schema::dropIfExists('payments_split_rules');
    }
}
