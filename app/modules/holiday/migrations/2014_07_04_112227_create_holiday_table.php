<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidayTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday', function (Blueprint $table) {
            $table->increments('id');

            $table->text('description')->nullable();

            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('place_of_payment')->nullable();
            $table->string('card_type')->nullable();

            $table->string('text_position')->default('bottom');
            $table->string('text_color')->default('#ffffff');
            $table->string('text_size')->default('20');
            $table->string('bg_color')->default('#000000');
            $table->string('bg_transparency')->default('50');
            $table->string('angle')->default(0);
            $table->string('font')->default('Verdana-Italic.ttf');

            $table->integer('greyscale')->default(0);

            $table->integer('stage')->default(0);
            $table->integer('status')->default(0);
            $table->string('hash_delete')->nullable();
            $table->string('hash_activate')->nullable();

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
        Schema::drop('holiday');
    }

}
