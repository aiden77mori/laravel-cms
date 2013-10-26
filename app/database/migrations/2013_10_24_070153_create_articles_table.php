<?php

use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('articles', function ($table) {

            $table->increments('id');
            $table->string('title', 255);
            $table->text('content');
            $table->timestamps();
            $table->boolean('is_published')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        
         Schema::drop('articles');
    }
}