<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelNamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_names', function (Blueprint $table) {
            $table->bigIncrements('req_id');
            $table->bigInteger('votes')->nullable();
            $table->binary('data')->nullable();
            $table->boolean('confirmed')->nullable();
            $table->char('name', 4)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->decimal('amount',5 ,2)->nullable();
            $table->double('column',15, 8)->nullable();
            $table->enum('choices', array('foo','bar'))->nullable();
            $table->float('amount_one');
            $table->integer('votess')->nullable();
            $table->mediumInteger('number')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_names');
    }
}
