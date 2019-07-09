<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->uuid('uuid')->index();

            $table->string('name');
            $table->bigInteger('amount');
            $table->unsignedBigInteger('accountable_id');
            $table->unsignedBigInteger('tenancy_id');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('accountable_id')->references('id')->on('users');
            $table->foreign('tenancy_id')->references('id')->on('tenancies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
