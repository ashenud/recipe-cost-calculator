<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_heads', function (Blueprint $table) {
            $table->id('recipe_id');
            $table->string('recipe_name')->nullable();
            $table->date('recipe_date')->nullable();
            $table->string('recipe_code')->nullable()->unique();

            $table->unsignedBigInteger('recipe_category')->nullable();
            $table->foreign('recipe_category')->references('rc_id')->on('recipe_categories');

            $table->unsignedBigInteger('recipe_currency')->nullable();
            $table->foreign('recipe_currency')->references('cur_id')->on('system_currencies');

            $table->string('recipe_image')->nullable();
            $table->text('recipe_preparation')->nullable();
            $table->decimal('recipe_cost', 20, 2)->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('recipe_heads');
    }
}
