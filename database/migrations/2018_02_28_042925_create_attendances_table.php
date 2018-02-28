<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id');
            $table->bigInteger('user_id');
            $table->dateTime('origin_in');
            $table->dateTime('origin_out')->nullable();
            $table->dateTime('in');
            $table->dateTime('out')->nullable();
            $table->float('normal', 5, 2)->nullable();
            $table->float('overtime', 5, 2)->nullable();
            $table->timestamps();
            $table->tinyInteger('deleted')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
