<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('alt', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 255);
            $table->integer('model_id');
            $table->string('model_type', 255);
            $table->integer('sort')->default(0);

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
        Schema::drop('images');
	}

}
