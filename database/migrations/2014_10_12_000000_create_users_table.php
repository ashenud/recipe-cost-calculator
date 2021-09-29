<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('u_id');
            $table->string('name');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('role_id')->on('user_roles');
            $table->string('email')->unique()->nullable(); 
            $table->timestamp('email_verified_at')->nullable();            
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->integer('status')->default('1')->comment('1-active, 0-inactive');
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
        Schema::dropIfExists('users');
    }
}
