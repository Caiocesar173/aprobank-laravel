<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankUserAlterId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_user', function (Blueprint $table) {
            $table->uuid('account_id')->nullable()->after('id');
            $table->uuid('buyer_id')->nullable()->after('id');
            $table->uuid('payer_id')->nullable()->unique()->after('id');
            $table->uuid('address_id')->nullable()->after('id');
            $table->nullableMorphs('responsable');
            
            $table->dropForeign('bank_user_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropColumn('uuid_external');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_user');
    }
}
