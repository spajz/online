<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnlineTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->integer('sort')->default(0);
            $table->integer('status')->default(0);
            $table->integer('menu')->default(0);
            $table->integer('featured')->default(0);

            $table->string('seo_title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();

            $table->index('sort');
            $table->index('status');
            $table->index('slug');
            $table->index('menu');
            $table->index('featured');

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
        Schema::drop('online');
    }

}
