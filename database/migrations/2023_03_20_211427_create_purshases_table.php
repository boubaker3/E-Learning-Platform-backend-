<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurshasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purshases', function (Blueprint $table) {
            $table->id();
            $table->string('purshaseid');
            $table->string('sellerid');
            $table->string('userid');
            $table->string('courseid');
            $table->string('payerid');
            $table->string('paymentid')->unique();
            $table->float('amount');
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
        Schema::dropIfExists('purshases');
    }
}
