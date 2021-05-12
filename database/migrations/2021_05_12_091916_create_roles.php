<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('key')->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });

        Schema::create('sectors', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('name');
            $table->string('key')->unique();
        });


        Schema::create('editorial_project', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('publication_date')->nullable();
            $table->unsignedTinyInteger('sector_id');
            $table->unsignedBigInteger('author_id');
            $table->unsignedInteger('pages')->nullable();
            $table->unsignedFloat('price')->nullable();
            $table->unsignedFloat('cost')->nullable();
            $table->timestamps();
            $table->foreign('author_id')->references('id')->on('');



        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('roles');
    }
}
