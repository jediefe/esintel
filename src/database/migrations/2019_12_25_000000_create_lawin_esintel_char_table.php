<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawinEsintelCharTable extends Migration
{
    public function up()
    {
        Schema::create('lawin_esintel_chars', function(Blueprint $table){
            $table->increments('id');
            $table->integer('character_id')->unsigned()->unique();
            $table->integer('main_character_id')->unsigned()->nullable();
            $table->tinyInteger('es')->unsigned();
            $table->tinyInteger('intel_category')->unsigned()->nullable();
            $table->text('intel_text')->nullable();
            $table->timestamps();
        });

        Schema::create('lawin_esintel_categories', function(Blueprint $table){
            $table->increments('id');
            $table->string('category_name');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lawin_esintel_chars');
        Schema::dropIfExists('lawin_esintel_categories');
    }
}