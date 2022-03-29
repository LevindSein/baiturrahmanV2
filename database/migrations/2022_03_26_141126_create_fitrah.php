<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFitrah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fitrah', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10);
            $table->json('muzakki');
            $table->json('jumlah');
            $table->string('admin', 255);
            $table->tinyInteger('status');
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
        Schema::dropIfExists('fitrah');
    }
}
