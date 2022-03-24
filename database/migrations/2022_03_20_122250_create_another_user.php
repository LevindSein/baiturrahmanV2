<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnotherUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('another_user', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hp', 13);
            $table->text('address');
            $table->bigInteger('family')->nullable();
            $table->boolean('muzakki')->nullable();
            $table->boolean('stt_muzakki')->nullable();
            $table->boolean('mustahik')->nullable();
            $table->boolean('stt_mustahik')->nullable();
            $table->tinyInteger('type_mustahik')->nullable();
            $table->datetime('updated_at')->useCurrent();
            $table->datetime('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('another_user');
    }
}
