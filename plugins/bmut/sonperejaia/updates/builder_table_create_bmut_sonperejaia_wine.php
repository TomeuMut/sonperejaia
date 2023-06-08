<?php namespace Bmut\SonPereJaia\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateBmutSonperejaiaWine extends Migration
{
    public function up()
    {
        Schema::create('bmut_sonperejaia_wine', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name', 255)->nullable();
            $table->text('description')->nullable();
            $table->decimal('alcohol', 10, 0)->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('bmut_sonperejaia_wine');
    }
}
