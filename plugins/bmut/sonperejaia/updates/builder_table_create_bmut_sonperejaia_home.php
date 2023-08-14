<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutSonperejaiaHome extends Migration
{
    public function up()
    {
        Schema::create('bmut_sonperejaia_home', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('block_one_title', 255);
            $table->string('block_one_subtitle', 255)->nullable();
            $table->text('block_one_description')->nullable();
            $table->string('block_two_title', 255)->nullable();
            $table->string('block_three_title', 255)->nullable();
            $table->text('block_three_description')->nullable();
            $table->string('block_three_title_2', 255)->nullable();
            $table->text('block_three_description_2')->nullable();
            $table->string('block_four_title', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_sonperejaia_home');
    }
}
