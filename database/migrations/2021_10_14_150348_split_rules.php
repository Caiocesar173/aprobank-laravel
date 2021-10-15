<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class SplitRules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('split_rules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->text('name');
            $table->text('type_user');
            $table->text('type_value');
            $table->decimal('value', 11, 2);

            $table->uuid('split_id');
            $table->foreign('split_id')->references('id')->on('split')->onDelete('cascade');

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
