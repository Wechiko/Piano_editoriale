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
            $table->string('description')->nullable();
            $table->string('key')->unique();
        });


        Schema::create('editorial_project', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('sector_id');
            $table->unsignedBigInteger('author_id');
            $table->boolean('is_approved_by_ceo')->default(false);
            $table->boolean('is_approved_by_editorial_director')->default(false);
            $table->boolean('is_approved_by_editorial_responsible')->default(false);
            $table->boolean('is_approved_by_sales_director')->default(false);
            $table->string('title');
            $table->date('publication_date')->nullable();
            $table->unsignedInteger('pages')->nullable();
            $table->unsignedFloat('price')->nullable();
            $table->unsignedFloat('cost')->nullable();
            $table->foreign('author_id')->references('id')->on('users');
            $table->foreign('sector_id')->references('id')->on('sectors');
            $table->timestamps();
            $table->softDeletes();



        });
        Schema::create('editorial_project_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('editorial_project_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('action',['CREATE','UPDATE','DESTROY']);
            $table->dateTimeTz('created_at')->default(\Carbon\Carbon::now());
            $table->foreign('editorial_project_id')->references('author_id')->on('editorial_project')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('editorial_project_logs');
        Schema::dropIfExists('editorial_project');
        Schema::dropIfExists('sectors');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('roles');
    }
}
