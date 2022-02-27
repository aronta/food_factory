<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_translations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('locale')->index();
            $table->unsignedBigInteger('meal_id');
            $table->string('title');
            $table->text('description');

            $table->unique(['meal_id', 'locale']);
            $table->foreign('locale')->references('locale')->on('languages')->onDelete('CASCADE');
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_translations');
    }
}
