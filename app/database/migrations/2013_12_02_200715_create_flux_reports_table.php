<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxreportsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_reports', function($table) {
            $table->increments('id');
            $table->integer('post_id');
            $table->integer('topic_id');
            $table->integer('forum_id');
            $table->integer('reported_by');
            $table->integer('created');
            $table->text('message')->nullable();
            $table->integer('zapped')->nullable()->index();
            $table->integer('zapped_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_reports');
    }

}