<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->index();
            $table->unsignedBigInteger('entry_id');
            $table->integer('number');
            $table->bigInteger('value');
            $table->date('due_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('description')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('entry_id')->references('id')->on('entries');

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
        Schema::dropIfExists('parcels');
        Schema::enableForeignKeyConstraints();
    }
}
