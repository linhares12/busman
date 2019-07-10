<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->uuid('uuid')->index();

            $table->string('description');
            $table->string('type');

            $table->unsignedBigInteger('tenancy_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('spender_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenancy_id')->references('id')->on('tenancies');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('spender_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('entries');
        Schema::enableForeignKeyConstraints();
    }
}
