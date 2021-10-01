<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->bigIncrements('in_id');            
            $table->string('in_name')->nullable();

            $table->unsignedBigInteger('in_cat_id')->nullable();
            $table->foreign('in_cat_id')->references('in_cat_id')->on('ingredient_categories');
            
            $table->string('in_code')->nullable()->unique();
            $table->string('in_short_name')->nullable();
            $table->string('in_other_names')->nullable();
            
            $table->decimal('price', 20, 2)->nullable();
            $table->string('pack_size')->nullable()->comment('case conversion');
            $table->decimal('weight_volume', 20, 2)->nullable()->comment('weight or volum qty');
            $table->string('unit')->nullable()->comment('kg,g,l,ml');

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
        Schema::dropIfExists('ingredients');
    }
}
