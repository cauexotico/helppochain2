<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blockchain_id');
            $table->unsignedBigInteger('miner')->nullable();
            $table->unsignedBigInteger('nonce');
            $table->integer('height');
            $table->char('previous_hash', 64);
            $table->char('hash', 64);
            $table->enum('status',['not_mined','mined']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('blockchain_id')->references('id')->on('blockchains')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('miner')->references('id')->on('projects')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks');
    }
}
