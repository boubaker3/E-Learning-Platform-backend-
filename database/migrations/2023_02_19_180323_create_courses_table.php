<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string("userid");
            $table->string("courseid");
            $table->string("title");
            $table->string("description",5000);
            $table->string("requirements");
            $table->string("benefits",1500);
            $table->string("category");
            $table->string("price");
            $table->string("paid_or_free");
            $table->string("thumb");
            $table->float("rating")->default(0);
            $table->integer("oneStar")->default(0);
            $table->integer("twoStars")->default(0);
            $table->integer("threeStars")->default(0);
            $table->integer("fourStars")->default(0);
            $table->integer("fiveStars")->default(0);
            $table->bigInteger("views")->default(0);
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
        Schema::dropIfExists('courses');
    }
}
