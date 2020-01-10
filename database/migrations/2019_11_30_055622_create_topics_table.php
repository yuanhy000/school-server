<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('content');
            $table->integer('likes')->default(0);
            $table->integer('views')->default(0);
            $table->string('location');
            $table->double('temperature')->nullable();
            $table->integer('answer_count')->default(0);
            $table->boolean('display')->default(true);
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->boolean('display_location')->default(false);
            $table->boolean('anonymity')->default(false);
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
        Schema::dropIfExists('topics');
    }
}
