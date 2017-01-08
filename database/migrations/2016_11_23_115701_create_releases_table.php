<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('type');
            $table->string('reference');
            $table->string('recurrence');
            $table->integer('category')->unsigned();
            $table->string('status')->default('pending');
            $table->date('payday');
            $table->double('value', 40, 20);
            $table->integer('account')->unsigned();

            $table->timestamps();

            $table->foreign('category')->references('id')->on('categories');
            $table->foreign('account')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('releases');
        
    }
}
