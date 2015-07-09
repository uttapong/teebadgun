<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxpostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_posts', function($table) {
            $table->increments('id');
            $table->string('poster', 200);
            $table->integer('poster_id')->default("1")->index();
            $table->string('poster_ip', 39)->nullable();
            $table->string('poster_email', 80)->nullable();
            $table->text('message')->nullable();
            $table->boolean('hide_smilies');
            $table->integer('posted');
            $table->integer('edited')->nullable();
            $table->string('edited_by', 200)->nullable();
            $table->integer('topic_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_posts');
    }

}