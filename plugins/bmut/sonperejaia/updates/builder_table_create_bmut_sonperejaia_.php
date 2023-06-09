<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutSonperejaia extends Migration
{
    public function up()
    {
        Schema::create('bmut_sonperejaia_', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('tag_id');
            $table->integer('sort_order');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_sonperejaia_');
    }
}
