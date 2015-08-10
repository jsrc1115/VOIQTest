<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('contact_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unsigned();
            $table->string('email');
            $table->boolean('primary');
            $table->timestamps();

            $table->foreign('contact_id')->references('id')->on('contacts')
                ->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('contact_numbers',function (Blueprint $table){
            $table->increments('id');
            $table->integer('contact_id')->unsigned();
            $table->string('phone_number');
            $table->timestamps();

            $table->foreign('contact_id')->references('id')->on('contacts')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contact_emails');
        Schema::drop('contact_numbers');
        Schema::drop('contacts');
    }
}
