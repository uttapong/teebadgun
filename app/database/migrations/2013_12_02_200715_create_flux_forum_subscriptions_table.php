<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxforumsubscriptionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_forum_subscriptions', function($table) {
            $table->increments('id');
            $table->integer('user_id')->primary();
            $table->integer('forum_id')->primary();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_forum_subscriptions');
    }

}