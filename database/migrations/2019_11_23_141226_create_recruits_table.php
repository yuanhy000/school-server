<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('content');
            $table->string('target');
            $table->integer('likes')->default(0);
            $table->integer('views')->default(0);
            $table->string('location');
            $table->boolean('display')->default(true);
            $table->double('temperature')->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->boolean('display_location')->default(false);
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
        Schema::dropIfExists('recruits');
    }
}
