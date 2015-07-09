<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxtopicsubscriptionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_topic_subscriptions', function($table) {
            $table->increments('id');
            $table->integer('user_id')->primary();
            $table->integer('topic_id')->primary();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_topic_subscriptions');
    }

}