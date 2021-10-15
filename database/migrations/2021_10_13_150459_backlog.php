<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class Backlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backlog', function (Blueprint $table) {
            $table->uuidMorphs('id')->primary();
            $table->text('status');
            $table->smallInteger('code')->nullable();
            $table->text('url');
            $table->text('type');
            $table->text('token');
            $table->json('payload')->nullable();
            $table->json('headers');
            $table->json('response');
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
        Schema::dropIfExists('backlog');
    }
}
