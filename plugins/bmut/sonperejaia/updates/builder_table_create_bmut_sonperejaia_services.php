<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutSonperejaiaServices extends Migration
{
    public function up()
    {
        Schema::create('bmut_sonperejaia_services', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('title', 255)->nullable();
            $table->text('description')->nullable();
            $table->string('slug', 255)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_sonperejaia_services');
    }
}
