<?php

use Illuminate\Database\Migrations\Migration;

class CreateFluxusersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flux_users', function($table) {
            $table->increments('id');
            $table->integer('group_id')->default("3");
            $table->string('username', 200)->unique();
            $table->string('password', 60);
            $table->string('email', 80);
            $table->string('title', 50)->nullable();
            $table->string('realname', 40)->nullable();
            $table->string('url', 100)->nullable();
            $table->string('location', 30)->nullable();
            $table->text('signature')->nullable();
            $table->integer('disp_topics')->nullable();
            $table->integer('disp_posts')->nullable();
            $table->integer('email_setting')->default("1");
            $table->boolean('notify_with_post');
            $table->boolean('auto_notify');
            $table->boolean('show_smilies')->default("1");
            $table->boolean('show_img')->default("1");
            $table->boolean('show_img_sig')->default("1");
            $table->boolean('show_avatars')->default("1");
            $table->boolean('show_sig')->default("1");
            $table->float('timezone')->default("0.00");
            $table->boolean('dst');
            $table->integer('time_format');
            $table->integer('date_format');
            $table->string('language', 25);
            $table->string('style', 25);
            $table->integer('num_posts');
            $table->integer('last_post')->nullable();
            $table->integer('last_search')->nullable();
            $table->integer('last_email_sent')->nullable();
            $table->integer('last_report_sent')->nullable();
            $table->integer('registered')->index();
            $table->string('registration_ip', 35)->default("0.0.0.0");
            $table->integer('last_visit');
            $table->string('admin_note', 30)->nullable();
            $table->string('activate_string', 80)->nullable();
            $table->string('activate_key', 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flux_users');
    }

}