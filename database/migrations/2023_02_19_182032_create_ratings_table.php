<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string("ratingid");
            $table->string("courseid");
            $table->string("senderid");
            $table->string("review",1000);
            $table->float("rating")->default(0);
            $table->integer("oneStar")->default(0);
            $table->integer("twoStars")->default(0);
            $table->integer("threeStars")->default(0);
            $table->integer("fourStars")->default(0);
            $table->integer("fiveStars")->default(0);
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
        Schema::dropIfExists('ratings');
    }
}
