<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blockchain_id');
            $table->char('name',100);
            $table->enum('type',['solo','shared']);
            $table->string('public_key', 64);
            $table->string('secret_key', 64);
            $table->string('start_version', 20);
            $table->string('current_version', 20);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('blockchain_id')->references('id')->on('blockchains')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
